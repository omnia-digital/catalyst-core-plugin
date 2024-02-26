@php use Filament\Facades\Filament; @endphp
<x-catalyst::dropdown align="right" width="48">
    <x-slot name="trigger">
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                <img class="h-8 w-8 rounded-full object-cover"
                     src="{{ auth()->user()?->profile_photo_url }}"
                     alt="{{ auth()->user()->name }}"/>
            </button>
        @else
            <span class="inline-flex rounded-md">
                                                <button type="button"
                                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-base-text-color bg-secondary hover:text-dark-text-color focus:outline-none transition">
                                                    {{ auth()->user()->name }}
                                                    <div>
                                                        <img class="inline-block h-8 w-8 rounded-full"
                                                             src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                                                             alt=""/>
                                                    </div>
                                                    <svg class="-mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                         viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                              clip-rule="evenodd"/>
                                                    </svg>
                                                </button>
                                            </span>
        @endif
    </x-slot>

    <x-slot name="content">
        {{ Filament::renderHook('user-menu.account.before') }}

        <!-- Account Management -->
        <div class="block px-4 py-2 text-xs text-light-text-color">
            {{ Translate::get('Manage Account') }}
        </div>

        <x-catalyst::dropdown-link
                href="{{ route('catalyst-social.profile.show', ['profile' => auth()->user()->handle]) }}">
            {{ auth()->user()->name }}
        </x-catalyst::dropdown-link>

        {{--                            <x-catalyst::dropdown-link href="{{ route('resources.drafts') }}">--}}
        {{--                                My Resources--}}
        {{--                            </x-catalyst::dropdown-link>--}}

        <x-catalyst::dropdown-link href="{{ route('media.index') }}">
            Media Library
        </x-catalyst::dropdown-link>

        <x-catalyst::dropdown-link href="{{ route('account') }}">
            {{ Translate::get('Account') }}
        </x-catalyst::dropdown-link>
        {{ Filament::renderHook('user-menu.account.after') }}

        @if (\OmniaDigital\CatalystCore\Facades\Catalyst::isUsingStripe())
            <x-catalyst::dropdown-link href="{{ route('billing.stripe-billing') }}">
                {{ Translate::get('Billing') }}
            </x-catalyst::dropdown-link>
        @elseif (\OmniaDigital\CatalystCore\Facades\Catalyst::isUsingChargent() && \OmniaDigital\CatalystCore\Facades\Catalyst::isUsingUserSubscriptions())
            <x-catalyst::dropdown-link href="{{ route('billing.chargent-billing') }}">
                {{ Translate::get('Billing') }}
            </x-catalyst::dropdown-link>
        @endif

        {{--                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())--}}
        {{--                                    <x-catalyst::dropdown-link href="{{ route('api-tokens.index') }}">--}}
        {{--                                        {{ \Translate::get('API Tokens') }}--}}
        {{--                                    </x-catalyst::dropdown-link>--}}
        {{--                                @endif--}}

        <div class="border-t border-gray-100"></div>

        <!-- Authentication -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <x-catalyst::dropdown-link href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); this.closest('form').submit();">
                {{ Translate::get('Log Out') }}
            </x-catalyst::dropdown-link>
        </form>
    </x-slot>
</x-catalyst::dropdown>
