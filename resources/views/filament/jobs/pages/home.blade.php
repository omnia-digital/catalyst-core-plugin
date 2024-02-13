<x-filament-panels::page>
    <div>
{{--        @include('catalyst::livewire.jobs.components.filters', ['skipFilters' => ['has_attachment', 'members','my_teams']])--}}

        <div>
{{--            @include('catalyst::livewire.jobs.components.subscribe-widget')--}}

            @if (count($featuredJobs))
                <div>
                    <h2 class="text-xl font-medium text-gray-700 py-2">Featured Jobs</h2>

                    <ul class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($featuredJobs as $job)
                            <x-catalyst::jobs.job.featured-item wire:key="featured-job-{{ $job->id }}" :job="$job"/>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="mt-2">
                <h2 class="text-xl font-medium text-gray-700 py-2">Latest Jobs</h2>

                <div class="bg-white shadow overflow-hidden sm:rounded-md">
                    <ul>
                        @forelse ($jobs as $job)
                            @include('catalyst::components.jobs.job.item', [
                                'job' => $job,
                                'wire:key' => "latest-job-{{ $job->id }}",
                                'class' => "{{ $loop->first ? 'border-t border-gray-200' : '' }}"
                            ])
                        @empty
                            <li class="p-20 text-lg text-gray-600 text-center">
                                {{ Translate::get('Looking for help? Post a job and you can start getting applicants today.') }}
                                <p>
                                    <a href="{{ route('filament.jobs.pages.new-job') }}"
                                       class="my-2 inline-flex items-center px-4 py-2 border border-transparent leading-6 font-medium rounded-md text-white bg-red-600 hover:text-white-600 hover:bg-red-500
                              focus:outline-none focus:border-light-red-300 focus:shadow-outline-light-red active:bg-red-50 active:text-white-700 transition duration-150 ease-in-out">
                                        Post a job
                                    </a>
                                </p>
                            </li>

                        @endforelse
                    </ul>
                </div>
            </div>

            <x-catalyst::jobs.tooltip trigger="company">Company</x-catalyst::jobs.tooltip>
            <x-catalyst::jobs.tooltip trigger="location">Location</x-catalyst::jobs.tooltip>
            <x-catalyst::jobs.tooltip trigger="payment-type-budget">Payment Type & Budget</x-catalyst::jobs.tooltip>
        </div>
    </div>

</x-filament-panels::page>
