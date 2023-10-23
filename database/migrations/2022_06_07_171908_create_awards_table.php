<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use OmniaDigital\CatalystCore\Models\Award;

return new class extends Migration
{
    public function up()
    {
        Schema::create('awards', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('icon');
            $table->timestamps();
        });

        Schema::create('awardables', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Award::class, 'award_id');
            $table->nullableMorphs('awardable');
            $table->timestamps();

            $table->unique(['award_id', 'awardable_id', 'awardable_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('awardables');
        Schema::dropIfExists('awards');
    }
};
