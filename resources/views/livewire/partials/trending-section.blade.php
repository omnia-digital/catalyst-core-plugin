<section aria-labelledby="trending-heading" class="card">
    <div class="">
        <x-library::heading.2 id="trending-heading" class="px-4 py-3 text-xl font-medium text-h1-color">
            {{ $title }} {{ ucwords(Str::plural($type)) }}
        </x-library::heading.2>
        <div class="flow-root">
            <ul role="list" class="">
                @foreach ($posts as $post)
                    <li class="py-2 px-4 hover:bg-neutral-hover">
                        <div wire:click.prevent.stop="showPost('{{ $post->id }}')"
                             class="flex justify-between cursor-pointer">
                            <div class="flex-1">
                                <div class="font-bold">
                                    <span wire:click.prevent.stop="showProfile('{{ $post->user->url() }}')"
                                          class="hover:underline">{{ $post->title ?? $post->user->name }}</span>
                                </div>
                                <div class="line-clamp-2">
                                    {!! strip_tags($post->body) !!}
                                </div>
                            </div>
                            <div class="w-16 h-16">
                                <img class="rounded-lg flex-shrink-0 h-full object-cover"
                                     src="{{ $post->image ? $post->image : $post->user?->profile_photo_url }}" alt="{{
                                    $post->user->name }}"/>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="">
            <a href="{{ route('social.discover') }}"
               class="w-full block text-center px-4 py-4 shadow-sm text-sm font-medium rounded-md text-dark-text-color bg-secondary hover:bg-neutral-hover">
                View all
            </a>
        </div>
    </div>
</section>
