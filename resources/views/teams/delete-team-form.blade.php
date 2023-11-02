<x-action-section>
    <x-slot name="title">
        {{ Translate::get('Delete Team') }}
    </x-slot>

    <x-slot name="description">
        {{ Translate::get('Permanently delete this team.') }}
    </x-slot>

    <x-slot name="content">
        <div class="max-w-xl text-sm text-base-text-color">
            {{ Translate::get('Once a team is deleted, all of its resources and data will be permanently deleted. Before deleting this team, please download any data or information regarding this team that you wish to retain.') }}
        </div>

        <div class="mt-5">
            <catalyst::components.danger-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                {{ Translate::get('Delete Team') }}
            </catalyst::components.danger-button>
        </div>

        <!-- Delete Team Confirmation Modal -->
        <catalyst::components.confirmation-modal wire:model.live="confirmingTeamDeletion">
            <x-slot name="title">
                {{ Translate::get('Delete Team') }}
            </x-slot>

            <x-slot name="content">
                {{ Translate::get('Are you sure you want to delete this team? Once a team is deleted, all of its resources and data will be permanently deleted.') }}
            </x-slot>

            <x-slot name="footer">
                <catalyst::components.secondary-button wire:click="$toggle('confirmingTeamDeletion')" wire:loading.attr="disabled">
                    {{ Translate::get('Cancel') }}
                </catalyst::components.secondary-button>

                <catalyst::components.danger-button class="ml-2" wire:click="deleteTeam" wire:loading.attr="disabled">
                    {{ Translate::get('Delete Team') }}
                </catalyst::components.danger-button>
            </x-slot>
        </catalyst::components.confirmation-modal>
    </x-slot>
</x-action-section>
