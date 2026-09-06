<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->string('city')->nullable()->after('state');
        });
    }

    public function down()
    {
        Schema::table('organizers', function (Blueprint $table) {
            $table->dropColumn('city');
        });
    }
};