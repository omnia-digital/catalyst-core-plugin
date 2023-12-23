<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use OmniaDigital\CatalystCore\Models\Profile;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', static function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->string('timezone');
            $table->text('more_info_url')->nullable();
            $table->text('vendor_registration_url')->nullable();
            $table->text('buy_tickets_url')->nullable();
            $table->text('sponsor_registration_url')->nullable();
            $table->text('watch_live_url')->nullable();
            $table->text('watch_vod_url')->nullable();
            $table->dateTimeTz('starts_at')->nullable();
            $table->dateTimeTz('ends_at')->nullable();
            $table->boolean('is_all_day')->default(false);
            $table->boolean('is_recurring')->default(false);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_published')->default(false);
            $table->string('status')->nullable();
            $table->foreignIdFor(\App\Models\User::class, 'created_by');
            $table->foreign('created_by')->references('id')->on('users')->cascadeOnUpdate();
            $table->foreignIdFor(\App\Models\Team::class, 'team_id')->nullable();
            $table->foreign('team_id')->references('id')->on('teams')->cascadeOnUpdate();
            if (class_exists(\OmniaDigital\CatalystLocation\Models\Location::class)) {
                $table->foreignIdFor(\OmniaDigital\CatalystLocation\Models\Location::class, 'location_id')->nullable();
                $table->foreign('location_id')->references('id')->on('locations')->cascadeOnUpdate();
            }
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (app()->environment() !== 'local' || ! Schema::hasTable('events')) {
            return;
        }
        Schema::dropIfExists('events');
    }
};
