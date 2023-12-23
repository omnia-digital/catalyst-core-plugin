<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (Schema::hasColumn('model_has_roles', 'team_id')) {
            Schema::table('model_has_roles', function (Blueprint $table) {
                $table->dropPrimary('team_id');
                $table->dropColumn('team_id');
            });
        }
        Schema::table('model_has_roles', function (Blueprint $table) {
            $table->unsignedBigInteger('team_id')->nullable()->index();
        });
    }

    public function down()
    {
//        Schema::table('model_has_roles', function (Blueprint $table) {
//            $table->unsignedBigInteger('team_id')->change();
//        });
    }
};
