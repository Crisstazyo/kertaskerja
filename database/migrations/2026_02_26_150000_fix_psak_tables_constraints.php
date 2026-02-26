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
        $tables = ['psak_government', 'psak_private', 'psak_soe', 'psak_sme'];
        
        foreach ($tables as $tableName) {
            // Drop old unique constraints if they exist
            $oldConstraints = [
                $tableName . '_user_id_tanggal_unique',
                $tableName . '_user_id_periode_unique'
            ];
            
            foreach ($oldConstraints as $constraintName) {
                \DB::statement("ALTER TABLE `{$tableName}` DROP INDEX IF EXISTS `{$constraintName}`");
            }
            
            // Ensure the correct unique constraint exists
            $newIndexName = $tableName . '_user_id_periode_segment_unique';
            $indexExists = \DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = '{$newIndexName}'");
            
            if (empty($indexExists)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unique(['user_id', 'periode', 'segment']);
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this fix
    }
};
