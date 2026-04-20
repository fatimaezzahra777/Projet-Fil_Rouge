<?php

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
        Schema::table('medecins', function (Blueprint $table) {
            $table->integer('points')->default(0)->after('specialite');
        });

        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->boolean('medecin_points_awarded')->default(false)->after('statut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rendez_vous', function (Blueprint $table) {
            $table->dropColumn('medecin_points_awarded');
        });

        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn('points');
        });
    }
};
