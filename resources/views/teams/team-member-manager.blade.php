<div>
    @if (Gate::check('addTeamMember', $team))
        <x-section-border/>

        <!-- Add Team Member -->
        <div class="mt-10 sm:mt-0">
            <x-form-section submit="addTeamMember">
                <x-slot name="title">
                    {{ Translate::get('Add Team Member') }}
                </x-slot>

                <x-slot name="description">
                    {{ Translate::get('Add a new team member to your team, allowing them to collaborate with you.') }}
                </x-slot>

                <x-slot name="form">
                    <div class="col-span-6">
                        <div class="max-w-xl text-sm text-base-text-color">
                            {{ Translate::get('Please provide the email address of the person you would like to add to this team.') }}
                        </div>
                    </div>

                    <!-- Member Email -->
                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="email" value="{{ Translate::get('Email') }}"/>
                        <x-input id="email" type="email" class="mt-1 block w-full"
                                 wire:model.live="addTeamMemberForm.email"/>
                        <x-input-error for="email" class="mt-2"/>
                    </div>

                    <!-- Role -->
                    @if (count($this->roles) > 0)
                        <div class="col-span-6 lg:col-span-4">
                            <x-label for="role" value="{{ Translate::get('Role') }}"/>
                            <x-input-error for="role" class="mt-2"/>

                            <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                                @foreach ($this->roles as $index => $role)
                                    <button type="button"
                                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary focus:ring focus:ring-primary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                                            wire:click="$set('addTeamMemberForm.role', '{{ $role->key }}')">
                                        <div class="{{ isset($addTeamMemberForm['role']) && $addTeamMemberForm['role'] !== $role->key ? 'opacity-50' : '' }}">
                                            <!-- Role Name -->
                                            <div class="flex items-center">
                                                <div class="text-sm text-base-text-color {{ $addTeamMemberForm['role'] == $role->key ? 'font-semibold' : '' }}">
                                                    {{ $role->name }}
                                                </div>

                                                @if ($addTeamMemberForm['role'] == $role->key)
                                                    <svg class="ml-2 h-5 w-5 text-green-400" fill="none"
                                                         stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    </svg>
                                                @endif
                                            </div>

                                            <!-- Role Description -->
                                            <div class="mt-2 text-xs text-base-text-color text-left">
                                                {{ $role->description }}
                                            </div>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Invitation Message -->
                    {{-- <div class="col-span-6 sm:col-span-4">
                        <x-label for="message" value="{{ \Translate::get('Message') }}" />
                        <x-input id="message" type="text" class="mt-1 block w-full" wire:model.live="addTeamMemberForm.message" />
                        <x-input-error for="message" class="mt-2" />
                    </div> --}}
                </x-slot>

                <x-slot name="actions">
                    <x-action-message class="mr-3" on="saved">
                        {{ Translate::get('Added.') }}
                    </x-action-message>

                    <x-button>
                        {{ Translate::get('Add') }}
                    </x-button>
                </x-slot>
            </x-form-section>
        </div>
    @endif

    @if ($team->teamInvitations->isNotEmpty() && Gate::check('addTeamMember', $team))
        <x-section-border/>

        <!-- Team Member Invitations -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ Translate::get('Pending Team Invitations') }}
                </x-slot>

                <x-slot name="description">
                    {{ Translate::get('These people have been invited to your team and have been sent an invitation email. They may join the team by accepting the email invitation.') }}
                </x-slot>

                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->teamInvitations as $invitation)
                            <div class="flex items-center justify-between">
                                <div class="text-base-text-color">{{ $invitation->email }}</div>

                                <div class="flex items-center">
                                    @if (Gate::check('removeTeamMember', $team))
                                        <!-- Cancel Team Invitation -->
                                        <button class="cursor-pointer ml-6 text-sm text-red-500 focus:outline-none"
                                                wire:click="cancelTeamInvitation({{ $invitation->id }})">
                                            {{ Translate::get('Cancel') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    @if ($team->users->isNotEmpty())
        <x-section-border/>

        <!-- Manage Team Members -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ Translate::get('Team Members') }}
                </x-slot>

                <x-slot name="description">
                    {{ Translate::get('All of the people that are part of this team.') }}
                </x-slot>

                <!-- Team Member List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($team->users->sortBy('name') as $user)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <img class="w-8 h-8 rounded-full" src="{{ $user->profile_photo_url }}"
                                         alt="{{ $user->name }}">
                                    <div class="ml-4">{{ $user->name }}</div>
                                </div>

                                <div class="flex items-center">
                                    <!-- Manage Team Member Role -->
                                    @if (Gate::check('addTeamMember', $team) && Laravel\Jetstream\Jetstream::hasRoles())
                                        <button class="ml-2 text-sm text-light-text-color underline"
                                                wire:click="manageRole('{{ $user->id }}')">
                                            {{ $user->membership->role ? Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name : '' }}
                                        </button>
                                    @elseif (Laravel\Jetstream\Jetstream::hasRoles())
                                        <div class="ml-2 text-sm text-light-text-color">
                                            {{ $user->membership->role ? Laravel\Jetstream\Jetstream::findRole($user->membership->role)->name : '' }}
                                        </div>
                                    @endif

                                    <!-- Leave Team -->
                                    @if ($this->user->id === $user->id)
                                        <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                wire:click="$toggle('confirmingLeavingTeam')">
                                            {{ Translate::get('Leave') }}
                                        </button>

                                        <!-- Remove Team Member -->
                                    @elseif (Gate::check('removeTeamMember', $team))
                                        <button class="cursor-pointer ml-6 text-sm text-red-500"
                                                wire:click="confirmTeamMemberRemoval('{{ $user->id }}')">
                                            {{ Translate::get('Remove') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Role Management Modal -->
    <x-dialog-modal wire:model.live="currentlyManagingRole">
        <x-slot name="title">
            {{ Translate::get('Manage Role') }}
        </x-slot>

        <x-slot name="content">
            <div class="relative z-0 mt-1 border border-neutral-light rounded-lg cursor-pointer">
                @foreach ($this->roles as $index => $role)
                    <button type="button"
                            class="relative px-4 py-3 inline-flex w-full rounded-lg focus:z-10 focus:outline-none focus:border-primary focus:ring focus:ring-primary-light {{ $index > 0 ? 'border-t border-neutral-light rounded-t-none' : '' }} {{ ! $loop->last ? 'rounded-b-none' : '' }}"
                            wire:click="$set('currentRole', '{{ $role->key }}')">
                        <div class="{{ $currentRole !== $role->key ? 'opacity-50' : '' }}">
                            <!-- Role Name -->
                            <div class="flex items-center">
                                <div class="text-sm text-base-text-color {{ $currentRole == $role->key ? 'font-semibold' : '' }}">
                                    {{ $role->name }}
                                </div>

                                @if ($currentRole == $role->key)
                                    <svg class="ml-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round" stroke-width="2" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                @endif
                            </div>

                            <!-- Role Description -->
                            <div class="mt-2 text-xs text-base-text-color">
                                {{ $role->description }}
                            </div>
                        </div>
                    </button>
                @endforeach
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="stopManagingRole" wire:loading.attr="disabled">
                {{ Translate::get('Cancel') }}
            </x-secondary-button>

            <x-button class="ml-2" wire:click="updateRole" wire:loading.attr="disabled">
                {{ Translate::get('Save') }}
            </x-button>
        </x-slot>
    </x-dialog-modal>

    <!-- Leave Team Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingLeavingTeam">
        <x-slot name="title">
            {{ Translate::get('Leave Team') }}
        </x-slot>

        <x-slot name="content">
            {{ Translate::get('Are you sure you would like to leave this team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingLeavingTeam')" wire:loading.attr="disabled">
                {{ Translate::get('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="leaveTeam" wire:loading.attr="disabled">
                {{ Translate::get('Leave') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>

    <!-- Remove Team Member Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingTeamMemberRemoval">
        <x-slot name="title">
            {{ Translate::get('Remove Team Member') }}
        </x-slot>

        <x-slot name="content">
            {{ Translate::get('Are you sure you would like to remove this person from the team?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingTeamMemberRemoval')" wire:loading.attr="disabled">
                {{ Translate::get('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ml-2" wire:click="removeTeamMember" wire:loading.attr="disabled">
                {{ Translate::get('Remove') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>