<?php
// database/migrations/2025_10_14_110000_add_publisher_fk_to_series_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('series', function (Blueprint $table) {
            // Als kolom nog NIET bestaat:
            if (!Schema::hasColumn('series', 'publisher_id')) {
                $table->foreignId('publisher_id')
                    ->nullable() // zet weg als verplicht
                    ->after('user_id') // kies de positie die jij wilt
                    ->constrained('publishers')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            } else {
                // Als kolom wél bestaat maar zonder FK, voeg alleen de constraint toe
                $table->foreign('publisher_id')
                    ->references('id')->on('publishers')
                    ->cascadeOnDelete()
                    ->cascadeOnUpdate();
            }
        });
    }

    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            // eerst FK loslaten, dan kolom (alleen droppen als je 'm hierboven hebt aangemaakt)
            $table->dropForeign(['publisher_id']);
            // $table->dropColumn('publisher_id'); // undo alleen als jij de kolom hier hebt aangemaakt
        });
    }
};

