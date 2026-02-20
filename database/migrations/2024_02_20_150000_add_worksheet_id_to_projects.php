<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->foreignId('worksheet_id')->nullable()->after('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_user_added')->default(false)->after('worksheet_id'); // True if user added this row
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropForeign(['worksheet_id']);
            $table->dropColumn(['worksheet_id', 'is_user_added']);
        });
    }
};
