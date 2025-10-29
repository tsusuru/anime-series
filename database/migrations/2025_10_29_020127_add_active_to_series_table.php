<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_active_to_series_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('series', function (Blueprint $table) {
            if (!Schema::hasColumn('series','active')) {
                $table->boolean('active')->default(true)->after('publisher_id');
            }
        });
    }
    public function down(): void {
        Schema::table('series', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};
