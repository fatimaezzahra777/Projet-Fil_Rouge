<?php

namespace App\Http\Controllers;

use App\Models\Association;
use App\Models\Message;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();
        $search = trim((string) $request->string('search'));
        $contacts = $this->getAllowedContacts($user);
        $messagesTableExists = Schema::hasTable('messages');

        $messages = $messagesTableExists
            ? Message::query()
                ->with(['sender', 'receiver'])
                ->where(function ($query) use ($user) {
                    $query->where('sender_id', $user->id)
                        ->orWhere('receiver_id', $user->id);
                })
                ->latest()
                ->get()
            : collect();

        $latestMessagesByContact = $messages->unique(function (Message $message) use ($user) {
            return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
        })->keyBy(function (Message $message) use ($user) {
            return $message->sender_id === $user->id ? $message->receiver_id : $message->sender_id;
        });

        $conversations = $contacts->map(function (User $contact) use ($latestMessagesByContact) {
            $latestMessage = $latestMessagesByContact->get($contact->id);

            return [
                'id' => $contact->id,
                'name' => $this->getDisplayName($contact),
                'email' => $contact->email,
                'role' => $this->getChatRole($contact),
                'preview' => $latestMessage?->message ?? 'Commencer une nouvelle conversation.',
                'time' => $latestMessage?->created_at?->diffForHumans() ?? null,
                'unread_count' => 0,
                'active' => false,
            ];
        })
            ->when($search !== '', function (Collection $collection) use ($search) {
                $needle = mb_strtolower($search);

                return $collection->filter(function (array $conversation) use ($needle) {
                    $haystacks = [
                        $conversation['name'] ?? '',
                        $conversation['email'] ?? '',
                        $conversation['role'] ?? '',
                        $conversation['preview'] ?? '',
                    ];

                    foreach ($haystacks as $value) {
                        if (str_contains(mb_strtolower((string) $value), $needle)) {
                            return true;
                        }
                    }

                    return false;
                });
            })
            ->values();

        return view('messages.index', [
            'conversations' => $conversations,
            'messagesTableExists' => $messagesTableExists,
            'search' => $search,
        ]);
    }

    public function show(User $contact): View
    {
        $user = auth()->user();
        abort_unless($this->canChatWith($user, $contact), 403);
        abort_unless(Schema::hasTable('messages'), 404, 'La table messages n existe pas encore.');

        $messages = Message::query()
            ->with(['sender', 'receiver'])
            ->where(function ($query) use ($user, $contact) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $contact->id);
            })
            ->orWhere(function ($query) use ($user, $contact) {
                $query->where('sender_id', $contact->id)
                    ->where('receiver_id', $user->id);
            })
            ->oldest()
            ->get()
            ->map(function (Message $message) {
                return [
                    'sender_id' => $message->sender_id,
                    'sender_name' => $this->getDisplayName($message->sender),
                    'message' => $message->message,
                    'created_at' => $message->created_at,
                ];
            });

        return view('messages.show', [
            'contact' => [
                'id' => $contact->id,
                'name' => $this->getDisplayName($contact),
                'role' => $this->getChatRole($contact),
            ],
            'messages' => $messages,
        ]);
    }

    public function store(Request $request, User $contact): RedirectResponse
    {
        $user = auth()->user();
        abort_unless($this->canChatWith($user, $contact), 403);
        abort_unless(Schema::hasTable('messages'), 404, 'La table messages n existe pas encore.');

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Message::create([
            'sender_id' => $user->id,
            'receiver_id' => $contact->id,
            'message' => $validated['message'],
        ]);

        return redirect()
            ->route('messages.show', $contact)
            ->with('success', 'Message envoye avec succes.');
    }

    private function getAllowedContacts(User $user): Collection
    {
        if ($user->hasRole('patient') || $user->hasRole('association')) {
            $patients = Patient::query()
                ->with('user')
                ->where('user_id', '!=', $user->id)
                ->get()
                ->pluck('user');

            $associations = Association::query()
                ->with('user')
                ->where('is_validated', true)
                ->get()
                ->pluck('user')
                ->filter(fn (?User $contact) => $contact && $contact->id !== $user->id);

            return $patients
                ->merge($associations)
                ->filter()
                ->unique('id')
                ->sortBy(fn (User $contact) => [$this->getChatRole($contact), $this->getDisplayName($contact)])
                ->values();
        }

        return collect();
    }

    private function canChatWith(User $user, User $contact): bool
    {
        if ($user->id === $contact->id) {
            return false;
        }

        if ($user->hasRole('patient')) {
            return $contact->hasRole('patient') || $contact->hasRole('association');
        }

        if ($user->hasRole('association')) {
            return $contact->hasRole('patient') || $contact->hasRole('association');
        }

        return false;
    }

    private function getDisplayName(?User $user): string
    {
        if (! $user) {
            return 'Utilisateur';
        }

        if ($user->association && $user->association->nom) {
            return $user->association->nom;
        }

        return trim($user->prenom . ' ' . $user->nom) ?: $user->email;
    }

    private function getChatRole(User $user): string
    {
        if ($user->hasRole('association')) {
            return 'association';
        }

        if ($user->hasRole('patient')) {
            return 'patient';
        }

        return 'utilisateur';
    }
}
