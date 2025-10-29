<?php
// database/migrations/xxxx_xx_xx_xxxxxx_add_active_to_publishers_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('publishers', function (Blueprint $table) {
            $table->boolean('active')->default(true)->after('name');
        });
    }
    public function down(): void {
        Schema::table('publishers', function (Blueprint $table) {
            $table->dropColumn('active');
        });
    }
};

