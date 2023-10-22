<div>
    @auth
        @if ($team?->teamApplications()->hasUser(auth()->id()))
            <div class="relative py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-neutral-dark text-white-text-color opacity-75 text-center">
                {{ Translate::get('Awaiting Approval') }}
                <button
                        title="{{ Translate::get('Remove Application') }}"
                        wire:loading.attr="disabled"
                        wire:target="removeApplication"
                        class="absolute -right-2 -top-2 p-1 inline-flex items-center text-sm rounded-full group hover:bg-tertiary whitespace-nowrap bg-neutral-hover hover:underline"
                        wire:click="removeApplication"
                >
                    <x-library::icons.icon name="x-mark" class="w-4 h-4 text-black group-hover:text-white"/>
                    <span class="sr-only">{{ Translate::get('Remove Application') }}</span>
                </button>
            </div>
        @elseif (!$team?->hasUser(auth()->user()))
            <div class="absolute -top-9 right-0 w-96">
                <x-input-error for="user_id" class="mt-2"/>
            </div>
            @can('apply', $team)
                <a
                        class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-primary text-white-text-color hover:opacity-75"
                        href="{{ route('catalyst-social.teams.application', $team) }}"
                >{{ \OmniaDigital\CatalystCore\Facades\Catalyst::applyButtonText() }}</a>
            @endcan
        @endif
    @else
        <button
                class="py-2 px-4 mx-2 inline-flex items-center text-sm rounded-full bg-primary text-white-text-color hover:opacity-75"
                wire:click.prevent="showAuthenticationModal('{{ route('catalyst-social.teams.show', $team) }}')"
        >{{ \OmniaDigital\CatalystCore\Facades\Catalyst::applyButtonText() }}</button>
    @endauth
</div>
