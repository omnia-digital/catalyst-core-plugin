<!-- Center Nav -->
<div class="hidden lg:block sm:col-span-8 2xl:col-span-9 justify-center items-center">
    <nav class="space-x-4 flex justify-center">
        @foreach ($navigation as $item)
            @if (\Catalyst::isModuleEnabled($item['module']))
                <catalyst::components.main-nav-link href="{{ !empty($item['name']) ? route($item['name']) : $item['url'] }}"
                                 :active="request()->route()->named($item['module'] . '*')">
                    <x-library::icons.icon :name="$item['icon']" class="w-6 h-6 mr-2"/>
                    {{ $item['label'] }}
                </catalyst::components.main-nav-link>
            @endif
        @endforeach
        @if (config('feedback.roadmap.url'))
            <catalyst::components.main-nav-link href="{{ config('feedback.roadmap.url') }}" target="_blank">
                <x-library::icons.icon name="fa-solid fa-road" class="w-6 h-6 mr-2"/>
                {{ Translate::get('Roadmap') }}
            </catalyst::components.main-nav-link>
        @endif
    </nav>
</div>
