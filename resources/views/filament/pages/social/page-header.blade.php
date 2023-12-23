@props([
    'actions' => $this->getCachedHeaderActions(),
    'breadcrumbs' => filament()->hasBreadcrumbs() ? $this->getBreadcrumbs() : [],
    'title' => 'Page',
    'subheading' => $this->getSubheading(),
])
<header
        {{ $attributes->class(['fi-header flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between
        sticky top-[55px] z-40 mb-4 rounded-b-lg pl-4 flex items-center items-center']) }}
>
    <div>
        @if ($breadcrumbs)
            <x-filament::breadcrumbs
                    :breadcrumbs="$breadcrumbs"
                    class="mb-2 hidden sm:block"
            />
        @endif

        <div class="flex-1 flex items-center">
            <x-library::icons.icon name="{{$icon ?? 'fa-regular fa-memo'}}" color="text-primary" class="h-8 w-8 mr-3"/>
            <x-library::heading.1
                    class="py-4 fi-header-heading text-2xl font-bold tracking-tight text-gray-950 sm:text-3xl dark:text-white"
                    textColor="text-primary">{{ $title ?? "Page" }}</x-library::heading.1>
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

