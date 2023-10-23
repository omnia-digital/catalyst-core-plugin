<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->string('bg_color')->nullable();
            $table->string('text_color')->nullable();
        });
    }

    public function down()
    {
        Schema::table('awards', function (Blueprint $table) {
            $table->dropColumn('bg_color');
            $table->dropColumn('text_color');
        });
    }
};
