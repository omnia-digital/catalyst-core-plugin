@props([
    'actions' => $this->getCachedHeaderActions(),
    'breadcrumbs' => filament()->hasBreadcrumbs() ? $this->getBreadcrumbs() : [],
    'title' => 'Page',
    'subheading' => $this->getSubheading(),
])
<header
        {{ $attributes->class(['fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between
         rounded-b-lg flex items-center items-center']) }}
>
    <div>
        @if ($breadcrumbs)
            <x-filament::breadcrumbs
                    :breadcrumbs="$breadcrumbs"
                    class="mb-2 hidden sm:block"
            />
        @endif

        @if($showTitle)
            <div class="w-full flex items-center">
                @if($showBackButton)
                    <div class="mr-4 hover:bg-neutral-dark p-1 rounded-full bg-primary hover:text-white">
                        <a href="{{ route('filament.jobs.home') }}">
                            <x-heroicon-o-arrow-left class="h-4 text-white"/>
                        </a>
                    </div>
                @endif
                <div class="items-center flex text-primary">
                    @if($icon)
                        <x-library::icons.icon name="{{$icon}}"
                                               class="h-8 w-8 mr-3"/>
                    @endif
                    <x-library::heading.1
                            class="py-4 fi-header-heading text-2xl font-bold tracking-tight sm:text-3xl dark:text-white py-4 hover:cursor-pointer"
                            textColor="text-primary">{{ Translate::get($title ?? "Page") }}</x-library::heading.1>
                </div>
            </div>
        @endif

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

