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
            // Add segment column if it doesn't exist
            if (!Schema::hasColumn($tableName, 'segment')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('segment')->after('periode')->default('nc_step14');
                });
            }
            
            // Drop old unique constraint if exists
            $indexName = $tableName . '_user_id_periode_unique';

            $indexExists = \DB::select("
                SHOW INDEX FROM `{$tableName}` 
                WHERE Key_name = '{$indexName}'
            ");

            if (!empty($indexExists)) {
                \DB::statement("ALTER TABLE `{$tableName}` DROP INDEX `{$indexName}`");
            }
            
            // Add new unique constraint with segment if it doesn't exist
            $newIndexName = $tableName . '_user_id_periode_segment_unique';
            $indexExists = \DB::select("SHOW INDEX FROM `{$tableName}` WHERE Key_name = '{$newIndexName}'");
            
            if (empty($indexExists)) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->unique(['user_id', 'periode', 'segment']);
                });
            }
            
            // Rename columns if they still have old names (using MariaDB syntax)
            if (Schema::hasColumn($tableName, 'commitment_ssl')) {
                \DB::statement("ALTER TABLE `{$tableName}` CHANGE `commitment_ssl` `commitment_order` DECIMAL(10, 2) NULL");
            }
            
            if (Schema::hasColumn($tableName, 'real_ssl')) {
                \DB::statement("ALTER TABLE `{$tableName}` CHANGE `real_ssl` `real_order` DECIMAL(10, 2) NULL");
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = ['psak_government', 'psak_private', 'psak_soe', 'psak_sme'];
        
        foreach ($tables as $tableName) {
            // Rename columns back
            Schema::table($tableName, function (Blueprint $table) {
                $table->renameColumn('commitment_order', 'commitment_ssl');
                $table->renameColumn('real_order', 'real_ssl');
            });
            
            Schema::table($tableName, function (Blueprint $table) {
                // Drop unique constraint with segment
                $table->dropUnique(['user_id', 'periode', 'segment']);
                
                // Remove segment column
                $table->dropColumn('segment');
                
                // Restore old unique constraint
                $table->unique(['user_id', 'periode']);
            });
        }
    }
};
