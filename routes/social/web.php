<?php

use Illuminate\Support\Facades\Route;
use OmniaDigital\CatalystCore\Catalyst;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Filament\Pages\Home;
use OmniaDigital\CatalystCore\Http\Middleware\GuestAccessMiddleware;
use OmniaDigital\CatalystCore\Livewire\Pages\Bookmarks\Index;
use OmniaDigital\CatalystCore\Livewire\Pages\Companies\Index as AllCompanies;
use OmniaDigital\CatalystCore\Livewire\Pages\Contacts\Index as ContactsIndex;
use OmniaDigital\CatalystCore\Livewire\Pages\Posts\Edit as EditPosts;
use OmniaDigital\CatalystCore\Livewire\Pages\Posts\Show as ShowPosts;
use OmniaDigital\CatalystCore\Livewire\Pages\Posts\Trending as DiscoverIndex;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Awards as ProfileAwards;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Edit as EditProfile;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Followers as ProfileFollowers;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Media as ProfileMedia;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Show as ShowProfile;
use OmniaDigital\CatalystCore\Livewire\Pages\Profiles\Teams as ProfileTeams;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Admin\ManageTeamMembers as TeamMembers;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Admin\TeamAdmin as EditTeam;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Apply as ApplyToTeam;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Awards as TeamAwards;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Calendar as TeamMapCalendar;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Discover as DiscoverTeams;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Followers as TeamFollowers;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Forms\Builder as TeamFormBuilder;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Forms\Submissions as TeamFormSubmissions;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Index as AllTeams;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Map as TeamMap;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\MyTeams;
use OmniaDigital\CatalystCore\Livewire\Pages\Teams\Show as ShowTeam;


Route::name('catalyst-social.')->prefix('social')
    ->group(function () {


        // Shorten URLs
        Route::get(
            '/' . Catalyst::getUsersLetter() . '/{profile}',
            ShowProfile::class
        )->middleware([GuestAccessMiddleware::class, 'verified'])->name('profile.show');

        // Shorten URLs
        Route::get(
            '/' . Catalyst::getUsersLetter() . '/{profile}',
            ShowProfile::class
        )->middleware([GuestAccessMiddleware::class, 'verified'])->name('profile.show');
        Route::get('/' . Catalyst::getTeamsLetter() . '/{team}', ShowTeam::class)->middleware([
            GuestAccessMiddleware::class,
            'verified',
        ])->name('social.teams.show');


        // Auth Routes
        Route::middleware([
            'auth.session',
//    GuestAccessMiddleware::class,
//    'verified'
        ])->group(function () {
            // the way twitter works is
            // /{handle} for profile
            // /{handle}/status/{post_id} for any type of post, whether it's a post or reply
            // /{messages}/{message_id} for messages
            Route::get('/home', Home::class)->name('home');
            Route::get('bookmarks', Index::class)->name('bookmarks');

            Route::get('/trending', DiscoverIndex::class)->name('discover');

            Route::name('profile.')->prefix('profiles')->group(function () {
                Route::get('{profile}', ShowProfile::class)->name('show.full-url');
                Route::get('{profile}/edit', EditProfile::class)->name('edit');
                Route::get('{profile}/media', ProfileMedia::class)->name('media');
                Route::get('{profile}/followers', ProfileFollowers::class)->name('followers');
                Route::get('{profile}/awards', ProfileAwards::class)->name('awards');
                Route::get('{profile}/' . Catalyst::getTeamsWord(), ProfileTeams::class)->name('teams');
            });

            Route::name('teams.')->prefix(Catalyst::getTeamsWord())->middleware([
                GuestAccessMiddleware::class,
                'verified',
            ])->group(function () {
                Route::get('/discover', DiscoverTeams::class)->name('discover');
                Route::get('/calendar', TeamMapCalendar::class)->name('calendar');
                Route::get('/map', TeamMap::class)->name('map');
                Route::get('/my-' . Catalyst::getTeamsWord(), MyTeams::class)->name('my-teams');
                Route::get('{team}', ShowTeam::class)->name('show.full-url');
                Route::get('{team}/admin', EditTeam::class)->name('admin');
                Route::get('{team}/admin/forms/create', TeamFormBuilder::class)->name('admin.forms.create');
                Route::get('{team}/admin/forms/{form}/edit', TeamFormBuilder::class)->name('admin.forms.edit');
                Route::get('{team}/members', TeamMembers::class)->name('members');
                Route::get('{team}/members', TeamFollowers::class)->name('members');
                Route::get('{team}/about', TeamFollowers::class)->name('about');
                Route::get('{team}/followers', TeamFollowers::class)->name('followers');
                Route::get('{team}/resources', TeamFollowers::class)->name('resources');
                Route::get('{team}/advice', TeamFollowers::class)->name('advice');
                Route::get('{team}/jobs', TeamFollowers::class)->name('jobs');
                Route::get('{team}/learn', TeamFollowers::class)->name('learn');
                Route::get('{team}/awards', TeamAwards::class)->name('awards');
                Route::get('{team}/forms/{form}/submissions', TeamFormSubmissions::class)->name('forms.submissions');
                Route::get('{team}/apply', ApplyToTeam::class)->name('application');
                Route::get('/', AllTeams::class)->name('home');
            });

            Route::name('companies.')->prefix(Translate::get('companies'))->middleware([
                GuestAccessMiddleware::class,
                'verified',
            ])->group(function () {
                Route::get('/', AllCompanies::class)->name('home');
            });

            Route::get('/posts/{post}', ShowPosts::class)->name('posts.show');
            Route::get('/posts/{post}/edit', EditPosts::class)->name('posts.edit');

            Route::name('contacts.')->prefix('contacts')->group(function () {
                Route::get('/', ContactsIndex::class)->name('index');
            });

            Route::get('/art', \OmniaDigital\CatalystCore\Livewire\Pages\Art\Index::class)->name('art');

            Route::get('/learn', function () {
                return 'Learn';
            })->name('learn');

            Route::get('/marketplace', function () {
                return 'Marketplace';
            })->name('marketplace');
            //        Route::get('/', function () {
            ////            return Inertia::render('Social/Home');
            //        })->name('social-home');
            //        Route::get('/explore', function () {
            //        })->name('explore');
            //        Route::get('/profile', [Profile::class, 'show'])->name('profile');
            //        Route::get('/bookmarks', function () {
            //        })->name('bookmarks');
        });
    });
