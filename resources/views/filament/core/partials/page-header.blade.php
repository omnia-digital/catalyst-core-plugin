@props([
    'actions' => $this->getCachedHeaderActions(),
    'breadcrumbs' => filament()->hasBreadcrumbs() ? $this->getBreadcrumbs() : [],
    'title' => 'Page',
    'subheading' => $this->getSubheading(),
])
<header
        {{ $attributes->class(['fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between
        sticky top-[60px] z-40 mb-4 rounded-b-lg pl-4 flex items-center items-center  bg-primary rounded-b-lg']) }}
>
    <div>
        @if ($breadcrumbs)
            <x-filament::breadcrumbs
                    :breadcrumbs="$breadcrumbs"
                    class="mb-2 hidden sm:block"
            />
        @endif

        <div class="w-full mb-3 px-4 flex items-center">
            <div class="mr-4 hover:bg-neutral-dark p-2 rounded-full bg-secondary hover:text-secondary">
                <a href="{{ route('filament.jobs.home') }}">
                    <x-heroicon-o-arrow-left class="h-6"/>
                </a>
            </div>
            <div class="items-center flex">
                <x-library::icons.icon name="{{$icon ?? 'fa-regular fa-memo'}}" color="text-white"
                                       class="h-8 w-8 mr-3"/>
                <x-library::heading.1
                        class="text-white py-4 fi-header-heading text-2xl font-bold tracking-tight sm:text-3xl dark:text-white py-4 hover:cursor-pointer"
                        textColor="text-primary">{{ Translate::get($title ?? "Page") }}</x-library::heading.1>
            </div>
        </div>

        @if ($subheading)
            <p
                    class="fi-header-subheading mt-2 max-w-2xl text-lg text-gray-600 dark:text-gray-400"
            >
                {{ $subheading }}
            </p>
        @endif
    </div>

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::page.header.actions.before', scopes: $this->getRenderHookScopes()) }}

    @if ($actions)
        <x-filament-actions::actions
                :actions="$actions"
                @class([
                    'shrink-0',
                    'sm:mt-7' => $breadcrumbs,
                ])
        />
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook('panels::page.header.actions.after', scopes: $this->getRenderHookScopes()) }}
</header>

