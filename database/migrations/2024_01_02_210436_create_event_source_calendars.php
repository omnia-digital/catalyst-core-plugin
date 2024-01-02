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
        if (!Schema::hasTable('event_source_calendar_types')) {
            Schema::create('event_source_calendar_types', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('slug');
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('event_source_calendars')) {
            Schema::create('event_source_calendars', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('description')->nullable()->default(null);
                $table->string('slug');
                $table->string('ext_calendar_id');
                $table->text('calendar_url');
                $table->foreignIdFor(\OmniaDigital\CatalystCore\Models\EventSourceCalendarType::class,
                    'event_source_calendar_type_id');
                $table->timestamps();

                $table->foreign('event_source_calendar_type_id')->references('id')->on('event_source_calendar_types');
            });
        }

        if (Schema::hasTable('events')) {
            Schema::table('events', function (Blueprint $table) {
                $table->foreignIdFor(\OmniaDigital\CatalystCore\Models\EventSourceCalendar::class, 'event_source_calendar_id')->nullable();
                $table->foreign('event_source_calendar_id')->references('id')->on('event_source_calendars')->cascadeOnUpdate();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('event_source_calendar_types');
        if (Schema::hasColumn('events', 'event_source_calendar_id')) {
            Schema::table('events', function (Blueprint $table) {
                $table->dropForeign(['event_source_calendar_id']);
            });
        Schema::dropColumns('events','event_source_calendar_id');
        }
        Schema::dropIfExists('event_source_calendars');
        Schema::enableForeignKeyConstraints();
    }
};
