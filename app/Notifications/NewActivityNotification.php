<?php

namespace App\Notifications;

use App\Models\Activite;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewActivityNotification extends Notification
{
    use Queueable;

    public function __construct(private readonly Activite $activite)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'activite_id' => $this->activite->id,
            'titre' => $this->activite->titre,
            'date' => $this->activite->date,
            'points' => $this->activite->points,
            'association' => $this->activite->association?->nom ?: 'Association',
            'message' => 'Une nouvelle activite a ete publiee : ' . $this->activite->titre,
        ];
    }
}
