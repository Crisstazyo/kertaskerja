<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add columns to track user-added data for lop_initiate_data
        Schema::table('lop_initiate_data', function (Blueprint $table) {
            if (!Schema::hasColumn('lop_initiate_data', 'added_by_user_id')) {
                $table->unsignedBigInteger('added_by_user_id')->nullable()->after('created_by');
            }
            if (!Schema::hasColumn('lop_initiate_data', 'is_user_added')) {
                $table->boolean('is_user_added')->default(false)->after('added_by_user_id');
            }
        });
        
        // Add foreign key if not exists
        if (!Schema::hasColumn('lop_initiate_data', 'added_by_user_id')) {
            Schema::table('lop_initiate_data', function (Blueprint $table) {
                $table->foreign('added_by_user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
        
        // Add columns to track user-added data for lop_private_initiated_data
        Schema::table('lop_private_initiated_data', function (Blueprint $table) {
            if (!Schema::hasColumn('lop_private_initiated_data', 'added_by_user_id')) {
                $table->unsignedBigInteger('added_by_user_id')->nullable();
            }
            if (!Schema::hasColumn('lop_private_initiated_data', 'is_user_added')) {
                $table->boolean('is_user_added')->default(false);
            }
        });
        
        // Add foreign key if not exists
        if (!Schema::hasColumn('lop_private_initiated_data', 'added_by_user_id')) {
            Schema::table('lop_private_initiated_data', function (Blueprint $table) {
                $table->foreign('added_by_user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
        
        // Add columns to track user-added data for lop_soe_initiated_data
        Schema::table('lop_soe_initiated_data', function (Blueprint $table) {
            if (!Schema::hasColumn('lop_soe_initiated_data', 'added_by_user_id')) {
                $table->unsignedBigInteger('added_by_user_id')->nullable();
            }
            if (!Schema::hasColumn('lop_soe_initiated_data', 'is_user_added')) {
                $table->boolean('is_user_added')->default(false);
            }
        });
        
        // Add foreign key if not exists
        if (!Schema::hasColumn('lop_soe_initiated_data', 'added_by_user_id')) {
            Schema::table('lop_soe_initiated_data', function (Blueprint $table) {
                $table->foreign('added_by_user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
        
        // Add columns to track user-added data for lop_sme_initiated_data
        Schema::table('lop_sme_initiated_data', function (Blueprint $table) {
            if (!Schema::hasColumn('lop_sme_initiated_data', 'added_by_user_id')) {
                $table->unsignedBigInteger('added_by_user_id')->nullable();
            }
            if (!Schema::hasColumn('lop_sme_initiated_data', 'is_user_added')) {
                $table->boolean('is_user_added')->default(false);
            }
        });
        
        // Add foreign key if not exists
        if (!Schema::hasColumn('lop_sme_initiated_data', 'added_by_user_id')) {
            Schema::table('lop_sme_initiated_data', function (Blueprint $table) {
                $table->foreign('added_by_user_id')->references('id')->on('users')->onDelete('set null');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('lop_initiate_data', function (Blueprint $table) {
            $table->dropForeign(['added_by_user_id']);
            $table->dropColumn(['added_by_user_id', 'is_user_added']);
        });
        
        Schema::table('lop_private_initiated_data', function (Blueprint $table) {
            $table->dropForeign(['added_by_user_id']);
            $table->dropColumn(['added_by_user_id', 'is_user_added']);
        });
        
        Schema::table('lop_soe_initiated_data', function (Blueprint $table) {
            $table->dropForeign(['added_by_user_id']);
            $table->dropColumn(['added_by_user_id', 'is_user_added']);
        });
        
        Schema::table('lop_sme_initiated_data', function (Blueprint $table) {
            $table->dropForeign(['added_by_user_id']);
            $table->dropColumn(['added_by_user_id', 'is_user_added']);
        });
    }
};
