<catalyst::x-guest-layout>
    <div class="pt-4 bg-neutral">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            <div>
                <catalyst::x-authentication-card-logo/>
            </div>

            <div class="w-full sm:max-w-2xl mt-6 p-6 bg-secondary shadow-md overflow-hidden sm:rounded-lg prose">
                {!! $terms !!}
            </div>
        </div>
    </div>
</catalyst::x-guest-layout>
