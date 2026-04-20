<?php

use App\Models\Medecin;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->integer('appointment_points_cost')
                ->default(Medecin::DEFAULT_APPOINTMENT_POINTS_COST)
                ->after('specialite');
        });

        if (Schema::hasColumn('medecins', 'points')) {
            DB::table('medecins')
                ->where('points', '>', 0)
                ->update(['appointment_points_cost' => DB::raw('points')]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medecins', function (Blueprint $table) {
            $table->dropColumn('appointment_points_cost');
        });
    }
};
