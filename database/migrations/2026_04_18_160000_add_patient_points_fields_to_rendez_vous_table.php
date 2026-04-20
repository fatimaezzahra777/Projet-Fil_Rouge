<?php

use App\Models\RendezVous;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->integer('points_cost')
                ->default(RendezVous::FIXED_POINTS_COST)
                ->after('statut');
            $table->boolean('patient_points_spent')
                ->default(false)
                ->after('points_cost');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropColumn(['points_cost', 'patient_points_spent']);
        });
    }
};
