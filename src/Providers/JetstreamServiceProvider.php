<?php

namespace OmniaDigital\CatalystCore\Providers;

use OmniaDigital\CatalystCore\Contracts\InvitesTeamMembers;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;
use OmniaDigital\CatalystCore\Actions\Jetstream\DeleteUser;
use OmniaDigital\CatalystCore\Actions\Teams\AddTeamMember;
use OmniaDigital\CatalystCore\Actions\Teams\CreateTeam;
use OmniaDigital\CatalystCore\Actions\Teams\DeleteTeam;
use OmniaDigital\CatalystCore\Actions\Teams\InviteTeamMember;
use OmniaDigital\CatalystCore\Actions\Teams\RemoveTeamMember;
use OmniaDigital\CatalystCore\Actions\Teams\UpdateTeamName;
use OmniaDigital\CatalystCore\Facades\Translate;
use OmniaDigital\CatalystCore\Models\Membership;

class JetstreamServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configurePermissions();

        Jetstream::useMembershipModel(Membership::class);

        Jetstream::createTeamsUsing(CreateTeam::class);
        Jetstream::updateTeamNamesUsing(UpdateTeamName::class);
        Jetstream::addTeamMembersUsing(AddTeamMember::class);
        /* Jetstream::inviteTeamMembersUsing(InviteTeamMember::class); */
        app()->singleton(InvitesTeamMembers::class, InviteTeamMember::class);
        Jetstream::removeTeamMembersUsing(RemoveTeamMember::class);
        Jetstream::deleteTeamsUsing(DeleteTeam::class);
        Jetstream::deleteUsersUsing(DeleteUser::class);
    }

    /**
     * Configure the roles and permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions([]);

        //        if (class_exists(BillingSettings::class) && \Schema::hasTable('settings')) {
        //            $usingTeamMemberSubs = (new BillingSettings())?->team_member_subscriptions;
        //        }

        $postPermissions = [
            'post-create',
            'post-read',
            'post-update',
            'post-delete',
        ];
        $feedPermissions = [
            'feed-create',
            'feed-read',
            'feed-update',
            'feed-delete',
        ];
        $awardPermissions = [
            'award-create',
            'award-read',
            'award-update',
            'award-delete',
        ];
        $reviewPermissions = [
            'review-create',
            'review-read',
            'review-update',
            'review-delete',
        ];
        $subscriptionPermissions = [
            'sub-create',
            'sub-read',
            'sub-update',
            'sub-delete',
        ];
        $eventPermissions = [
            'event-create',
            'event-read',
            'event-update',
            'event-delete',
        ];

        $allPermissions = [
            ...$postPermissions,
            ...$feedPermissions,
            ...$awardPermissions,
            ...$reviewPermissions,
            ...$eventPermissions,
        ];

        array_push($allPermissions, ...$subscriptionPermissions);

        $memberRoleDescription = 'Members are a part of your Team and can see content inside the Team';
        //        if ($usingTeamMemberSubs) {
        //            $memberRoleDescription .= " (excluding 'sub-only' content)";
        //        }

        Jetstream::role('member', 'Member', [
            'post-create',
            'post-read',
            'feed-read',
            'award-read',
            'review-create',
            'review-read',
        ])
            ->description(Translate::get($memberRoleDescription));

        if (! empty($usingTeamMemberSubs)) {
            Jetstream::role('subscriber', 'Subscriber', [
                'feed-read',
            ])
                ->description(Translate::get("Subscribers can view 'sub-only' content, including posts, chats, events and more. Assigning a new member this role is equivalent to giving a subscription for free."));
        }

        Jetstream::role('moderator', 'Moderator', [
            'post-read',
            'post-delete',
            'post-edit',
            'create',
        ])
            ->description(Translate::get('Moderators can also can edit and delete posts.'));

        Jetstream::role('admin', 'Administrator', [
            ...$allPermissions,
        ])
            ->description(Translate::get('Admins have access to everything except billing & subscription details.'));

        Jetstream::role('owner', 'Owner', [
            ...$allPermissions,
            'billing',
        ])
            ->description(Translate::get('There can only be 1 Owner. The owner is the user that has their financial & billing accounts linked to this Team'));
    }
}
