@php use OmniaDigital\CatalystCore\Models\Jobs\JobPosition; @endphp
<x-filament-panels::page>

    <div>
{{--        <div class="mb-3 rounded-b-lg px-4 flex items-center justify-between bg-primary-500">--}}
{{--            <div class="flex items-center">--}}
{{--                @if (auth()->user()->can('create', JobPosition::class))--}}
{{--                    @auth--}}
{{--                        <x-library::button.link--}}
{{--                                href="{{ route('filament.jobs.pages.new-job') }}"--}}
{{--                                class="py-2 w-full h-10"--}}
{{--                        >{{ Translate::get('+ Create Job') }}</x-library::button.link>--}}
{{--                        <livewire:resources::pages.resources.create/>--}}
{{--                    @else--}}
{{--                        <x-library::button--}}
{{--                                class="py-2 w-full h-10"--}}
{{--                                wire:click="loginCheck"--}}
{{--                        >+ New Resource--}}
{{--                        </x-library::button>--}}
{{--                        <livewire:authentication-modal/>--}}
{{--                    @endauth--}}
{{--                @endif--}}
{{--            </div>--}}
{{--        </div>--}}
        <div>
            <h2 class="text-xl font-medium text-gray-700 py-2">{{ Auth::user()->currentTeam->name }}'s Jobs</h2>

            <div class="bg-white shadow overflow-hidden sm:rounded-md">
                <ul>
                    @forelse ($jobs as $job)
                        @include('catalyst::components.jobs.job.item', [
                                'wire:key' => "latest-job-{{ $job->id }}",
                                'class' => "{{ $loop->first ? 'border-t border-gray-200' : '' }}",
                                'job' => $job,
                                'editable' => "true"
                            ])
                    @empty
                        <li class="p-20 text-center">
                            <p class="mb-4 text-lg text-gray-600">You don't have any jobs.</p>
                            <a href="{{ route('filament.jobs.pages.new-job') }}"
                               class="rounded shadow py-2 px-4 bg-primary-500 text-white hover:bg-primary-500 hover:shadow-2xl transition duration-200">
                                Create your first job
                            </a>
                        </li>
                    @endforelse
                </ul>
            </div>

            {{--  Tooltips  --}}
            <x-catalyst::jobs.tooltip trigger="company">{{ Translate::get('Company') }}</x-catalyst::jobs.tooltip>
            <x-catalyst::jobs.tooltip trigger="location">{{ Translate::get('Location') }}</x-catalyst::jobs.tooltip>
            <x-catalyst::jobs.tooltip trigger="payment-type-budget">{{ Translate::get('Payment Type & Budget') }}</x-catalyst::jobs.tooltip>
        </div>
    </div>
</x-filament-panels::page>
