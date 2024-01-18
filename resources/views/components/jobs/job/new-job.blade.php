<div>

    <x-library::heading.1 class="w-full px-4">Post a job</x-library::heading.1>

    <div class="flex justify-between my-6">
        <div class="w-full md:w-10/12 px-2 md:pr-6">

            @guest
                <div class="mb-4">
                    <x-panel>
                        <x-slot name="title">Login to manage all your jobs</x-slot>
                        <x-slot name="description">Login or fill the below form out and create a new account.</x-slot>
                        <x-slot name="action">
                            <x-form.button.link :href="route('login')" class="px-6 py-3">Login</x-form.button.link>
                        </x-slot>
                    </x-panel>
                </div>
            @endif

            {{--            <aside class="flex sm:hidden col-span-full mb-4 sm:mb-0">--}}
            {{--                <x-advertising/>--}}
            {{--            </aside>--}}

            <form wire:submit.prevent="{{ Auth::guest() ? 'showRegisterModal' : 'save' }}" action="#" method="POST">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-secondary py-6 px-4 space-y-6 sm:p-6">
                        <div>
                            <x-library::heading.2 class="text-lg leading-6 font-medium text-dark-text-color">New
                                JobPosition
                            </x-library::heading.2>
                        </div>

                        <div class="grid grid-cols-3 gap-6">
                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label for="title" value="JobPosition Title"/>
                                <x-input.text wire:model.live="title" id="title" placeholder="JobPosition Title"/>
                                <x-input.error for="title"/>
                            </div>

                            <div class="col-span-3 space-y-1">
                                <x-input.label value="JobPosition Description"/>
                                <x-input.textarea wire:model.live="description" id="description"
                                                  placeholder="JobPosition Description"/>
                                <x-input.error for="description"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Is Remote"/>
                                <x-input.toggle wire:model.live="is_remote" id="is-remote"/>
                                <x-input.error for="is_remote"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Preferred Location (Optional)" for="location"/>
                                <x-input.text wire:model.live="location" id="location" placeholder="Location"/>
                                <x-input.error for="location"/>
                                <x-input.help value='Example: "Remote", "Remote, USA Only", "New York City"'/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Tags"/>
                                <x-input.selects wire:model.live="selected_tags" :options="$tags" max="5" id="tags"
                                                 placeholder="Type for searching a tag."/>
                                <x-input.error for="selected_tags"/>
                                <x-input.help
                                        value="Maximum is 5 tags. Tags are useful for reaching the contractors with the experience you need."/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Apply Type"/>
                                <x-input.select wire:model="apply_type" :options="$applyTypes" id="apply-type"/>
                                <x-input.error for="apply_type"/>
                                <x-input.help value="Choose the method you want contractors to apply to your job."/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Hours needed per week"/>
                                <x-input.select wire:model="hours_per_week_id" :options="$hoursPerWeek"
                                                id="hours-per-week-id"/>
                                <x-input.error for="hours_per_week_id"/>
                                <x-input.help
                                        value="Choose the hours per week you need contractors to apply to your job."/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="URL to Description/Application" for="apply-value"/>
                                <x-input.text wire:model="apply_value" id="apply-value"
                                              placeholder="URL to Description/Application"/>
                                <x-input.error for="apply_value"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Payment Type"/>
                                <x-input.select wire:model="payment_type" :options="$paymentTypes"
                                                id="payment-type"/>
                                <x-input.error for="payment_type"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Budget (Optional)" for="budget"/>
                                <x-input.text wire:model.live="budget" id="budget" placeholder="Budget">
                                    <x-slot name="icon">
                                        <x-heroicon-o-currency-dollar class="h-5 w-5 text-light-text-color"/>
                                    </x-slot>
                                </x-input.text>
                                <x-input.error for="budget"/>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                @foreach ($projectSizes as $key => $project)
                                    <div class="flex pt-4">
                                        <x-input.radio wire:model="project_size_id" name="project_size_id"
                                                       id="{{ $project['title'] }}" value="{{ $project['id'] }}"/>
                                        <x-input.label class="pl-4 font-bold" value="{{ $project['title'] }}"/>
                                    </div>
                                    <div class="pl-8 pt-1">
                                        <p class="mt-1 text-sm leading-5 text-base-text-color">{{ $project['description'] }}</p>
                                    </div>

                                @endforeach
                                <x-input.error for="job.project_size_id"/>
                                <x-input.label value="Active"/>
                                <x-input.toggle wire:model="is_active" id="is-active"/>
                                <x-input.error for="is_active"/>
                            </div>

                            {{--                            <div class="col-span-3 space-y-1 sm:col-span-2">--}}
                            {{--                                <x-input.label value="Show Budget"/>--}}
                            {{--                                <x-input.toggle wire:model="show_budget" id="show_budget"/>--}}
                            {{--                                <x-input.error for="show_budget"/>--}}
                            {{--                            </div>--}}

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <fieldset>
                                    <div class="mb-2">
                                        <x-library::heading.2
                                                class="text-lg leading-6 font-medium text-dark-text-color">JobPosition
                                            Addons
                                        </x-library::heading.2>
                                        <p class="mt-1 text-sm leading-5 text-base-text-color">This information will be
                                            displayed publicly so be careful what you share.</p>
                                    </div>

                                    <ul class="space-y-6">
                                        @foreach ($addons as $addon)
                                            <li
                                                    wire:key="addon-{{ $addon->id }}"
                                                    wire:click="toggleAddon({{ $addon->id }})"
                                                    class="group relative rounded-lg shadow-sm cursor-pointer focus:outline-none focus:shadow-outline-blue">
                                                <div
                                                        class="rounded-lg border border-gray-300 bg-secondary px-6 py-4 hover:border-gray-400 group-focus:border-primary sm:flex sm:justify-between sm:space-x-4">
                                                    <div class="flex items-center space-x-0">
                                                        <div class="flex-shrink-0 flex items-center">
                                                            <span class="form-radio text-primary group-focus:bg-red-500"></span>
                                                        </div>
                                                        <div class="text-sm leading-5">
                                                            <p class="block font-medium text-dark-text-color">
                                                                {{ $addon->name }}
                                                            </p>
                                                            @if ($addon->description)
                                                                <div class="text-base-text-color">
                                                                    <span class="block sm:inline">{{ $addon->description }}</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="mt-2 flex text-sm leading-5 space-x-1 sm:mt-0 sm:block sm:space-x-0 sm:text-right">
                                                        <div class="font-medium text-dark-text-color">{{ Catalyst::money($addon->price) }}</div>
                                                    </div>
                                                </div>
                                                <div
                                                        class="{{ in_array($addon->id, $selected_addons) ? 'border-primary' : 'border-transparent"' }} absolute inset-0 rounded-lg border-2 pointer-events-none"></div>
                                            </li>
                                        @endforeach
                                    </ul>

                                    <x-input.error class="mt-2" for="selected_addons"/>
                                </fieldset>

                                <p class="font-bold text-lg pt-5">Price: {{ Catalyst::money($price ?? 0) }}</p>
                            </div>

                            <div class="col-span-3 space-y-1 sm:col-span-2">
                                <x-input.label value="Coupon"/>
                                <x-input.text wire:model.blur="coupon" id="coupon" placeholder="Coupon"/>
                                <x-input.error for="coupon"/>
                            </div>

                            @auth
                                <div class="col-span-3 space-y-1">
                                    <x-input.label value="Company"/>
                                    <div class="inline-flex items-center">
                                        <x-input.file wire:model.live="logo" id="logo"
                                                      :preview="$logo ? $logo->temporaryUrl() : Auth::user()->currentTeam->logoUrl"
                                                      class="mr-4"/>
                                        <x-input.company wire:model.live="team_id" :companies="$companies" id="company"/>
                                    </div>
                                    <x-input.error for="team_id"/>
                                    <x-input.error for="logo"/>
                                </div>
                            @endif

                            @if ($intent)
                                <div
                                        wire:ignore.self
                                        x-data="{
                                paymentMethod: @entangle('selected_payment_method').live,

                                stripe: null,

                                cardElement: null,

                                errorMessage: '',

                                cardHolderName: @entangle('card_holder_name'),

                                city: @entangle('city'),

                                country: @entangle('country'),

                                line1: @entangle('line1'),

                                postal_code: @entangle('postal_code'),

                                state: @entangle('state'),

                                isPaymentMethodUpdated: false,

                                newCard: null,

                                loading: false,

                                confirmCard: async function() {
                                    this.errorMessage = '';

                                    this.loading = true;

                                    if (!this.cardHolderName || !this.city || !this.country || !this.line1 || !this.postal_code || !this.state) {
                                        this.errorMessage = 'Please enter your billing address and card information';

                                        this.loading = false;

                                        return;
                                    }

                                    const { setupIntent, error } = await this.stripe.confirmCardSetup(
                                        '{{ $intent->client_secret }}', {
                                            payment_method: {
                                                card: this.cardElement,
                                                billing_details: {
                                                    name: this.cardHolderName,
                                                    address: {
                                                        city: this.city,
                                                        country: this.country,
                                                        line1: this.line1,
                                                        postal_code: this.postal_code,
                                                        state: this.state
                                                    },
                                                }
                                            }
                                        }
                                    );

                                    if (error) {
                                        this.errorMessage = error.message;
                                        this.loading = false;
                                    } else {
                                        @this.set('payment_method', setupIntent.payment_method);
                                        @this.call('updatePaymentMethod');
                                    }
                                }
                            }"
                                        x-init="function() {
                                this.stripe = Stripe('{{ config('services.stripe.key') }}');

                                this.cardElement = this.stripe.elements().create('card');

                                this.cardElement.mount('#card_element');
                            }"
                                        x-on:card.window="isPaymentMethodUpdated = true; newCard = $event.detail"
                                        class="col-span-3 sm:col-span-2"
                                >
                                    <fieldset>
                                        <div>
                                            <x-library::heading.2
                                                    class="text-lg leading-6 font-medium text-dark-text-color">Payment
                                            </x-library::heading.2>
                                            <p class="mt-1 text-sm leading-5 text-base-text-color">This information will
                                                be displayed publicly so be careful what you share.</p>
                                        </div>
                                        <div class="mt-2 bg-secondary rounded-md -space-y-px">
                                            <div
                                                    x-bind:class="{'bg-primary border-primary z-10': paymentMethod === 'new-card', 'border-neutral-light': paymentMethod !== 'new-card'}"
                                                    class="relative border rounded-tl-md rounded-tr-md p-4 flex {{ !Auth::user()->hasDefaultPaymentMethod() ? 'border rounded-bl-md rounded-br-md' : '' }}"
                                            >
                                                <x-input.radio x-model="paymentMethod" value="new-card" id="new-card"/>
                                                <x-input.label for="new-card" class="ml-3 flex flex-col cursor-pointer">
                                            <span
                                                    x-bind:class="{'text-primary': paymentMethod === 'new-card', 'text-dark-text-color': paymentMethod !== 'new-card'}"
                                                    class="block text-sm leading-5 font-medium"
                                            >
                                                Add a new card
                                            </span>
                                                </x-input.label>
                                            </div>

                                            @if (Auth::user()->hasDefaultPaymentMethod())
                                                <div
                                                        x-bind:class="{'bg-primary border-primary z-10': paymentMethod === 'previous-card', 'border-neutral-light': paymentMethod !== 'previous-card'}"
                                                        class="relative border rounded-bl-md rounded-br-md p-4 flex"
                                                >
                                                    <x-input.radio x-model="paymentMethod" value="previous-card"
                                                                   id="previous-card"/>
                                                    <x-input.label for="previous-card"
                                                                   class="ml-3 flex flex-col cursor-pointer">
                                                <span
                                                        x-bind:class="{'text-primary': paymentMethod === 'previous-card', 'text-dark-text-color': paymentMethod !== 'previous-card'}"
                                                        class="block text-sm leading-5 font-medium"
                                                >
                                                    Use {{ ucfirst(Auth::user()->card_brand) }} ending with {{ Auth::user()->card_last_four }}
                                                </span>
                                                    </x-input.label>
                                                </div>
                                            @endif
                                        </div>
                                    </fieldset>

                                    {{--   Card info and bliing address    --}}
                                    <div x-show="paymentMethod === 'new-card' && !isPaymentMethodUpdated"
                                         class="col-span-3 sm:col-span-2 space-y-4">
                                        <p class="mb-2 text-sm leading-5 text-base-text-color">Please fill in your card
                                            information and billing address.</p>

                                        <div>
                                            <x-input.label for="line1" value="Address"/>
                                            <x-input.text x-model="line1" id="line1" placeholder="Address"/>
                                            <x-input.error for="line1"/>
                                        </div>

                                        <div>
                                            <x-input.label for="city" value="City"/>
                                            <x-input.text x-model="city" id="city" placeholder="City"/>
                                            <x-input.error for="city"/>
                                        </div>

                                        <div>
                                            <x-input.label for="state" value="State"/>
                                            <x-input.text x-model="state" id="state" placeholder="State"/>
                                            <x-input.error for="state"/>
                                        </div>

                                        <div>
                                            <x-input.label for="postal_code" value="Postal Code"/>
                                            <x-input.text x-model="postal_code" id="postal_code"
                                                          placeholder="Postal Code"/>
                                            <x-input.error for="postal_code"/>
                                        </div>

                                        <div>
                                            <x-input.label for="country" value="Country"/>
                                            <x-input.select x-model="country" :options="Catalyst::countries()"
                                                            id="country"/>
                                            <x-input.error for="country"/>
                                        </div>

                                        <div>
                                            <x-input.label for="card_holder_name" value="Card Holder Name"/>
                                            <x-input.text x-model="cardHolderName" id="card_holder_name"
                                                          placeholder="John Smith"/>
                                            <x-input.error for="card_holder_name"/>
                                        </div>

                                        <!-- Stripe Elements Placeholder -->
                                        <div wire:ignore class="mt-2 relative rounded-md shadow-sm">
                                            <div id="card_element"
                                                 class="form-input block w-full sm:text-sm sm:leading-5"></div>
                                        </div>
                                        <x-input.error for="payment_method"/>

                                        <p x-show="errorMessage" x-text="errorMessage"
                                           class="text-red-500 text-sm mt-2"></p>

                                        <div class="py-2 flex justify-end">
                                            <button
                                                    x-on:click.prevent.stop="confirmCard"
                                                    x-bind:disabled="loading"
                                                    x-bind:class="{'bg-primary hover:bg-primary focus:bg-primary active:bg-primary': !loading, 'bg-gray-600 cursor-not-allowed': loading}"
                                                    class="py-1 px-4 border border-transparent text-sm text-white-text-color font-medium rounded-md shadow-sm focus:outline-none focus:shadow-outline-blue transition duration-150 ease-in-out">
                                                Update payment method
                                            </button>
                                        </div>
                                    </div>

                                    {{-- New card added info --}}
                                    <template x-if="newCard">
                                        <div class="rounded-md bg-green-50 mt-4 p-4">
                                            <div class="flex">
                                                <div class="flex-shrink-0">
                                                    <x-heroicon-s-check-circle class="h-5 w-5 text-green-400"/>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm leading-5 font-medium text-green-800">
                                                        <span class="uppercase" x-text="newCard?.card_brand"></span>
                                                        endings with <span x-text="newCard?.card_last_four"></span>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            @endif
                        </div>
                        {{--  Preview JobPosition  --}}
                        <div class="rounded border-2 mt-10">
                            <x-library::heading.2 class="text-xl text-center font-medium text-dark-text-color py-2">
                                Preview
                            </x-library::heading.2>
                            <p class="text-center font-bold">Here's a preview of how your jobpost will look like</p>
                            <p class="text-center">Don't worry if it's not perfect the first time: your job is fully
                                editable for free after posting it!</p>

                            <div class="bg-secondary shadow overflow-hidden sm:rounded-md">
                                <ul>
                                    <catalyst-jobs::components.job.item-preview
                                            :logoUrl="$logo ? $logo->temporaryUrl() : Auth::user()->currentTeam->logoUrl"
                                            :title="$title"
                                            :companyName="Arr::first($companies, fn($company) => $company->id === $team_id)->name"
                                            :location="$location"
                                            :isRemote="$is_remote"
                                            :paymentType="$payment_type"
                                            :budget="$budget"
                                            :tags="$tags"
                                            :selectedTags="$selected_tags"
                                    />
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                    <span class="w-full md:w-auto inline-flex rounded-md shadow-sm">
                        <x-form.button wire:target="save" class="w-full md:w-auto">Publish JobPosition</x-form.button>
                    </span>
                    </div>
                </div>
            </form>
        </div>
        {{--        <aside class="hidden sm:flex col-span-3 ">--}}
        {{--            <x-advertising/>--}}
        {{--        </aside>--}}
    </div>

    <x-dialog-modal wire:model.live="registerModalOpen">
        <x-slot name="title">Register an account</x-slot>
        <x-slot name="content">
            <div class="space-y-2">
                <x-library::alert.info>
                    <x-slot:content>Create an account to edit the job later.</x-slot:content>
                </x-library::alert.info>

                <div class="space-y-1">
                    <x-input.label value="Name"/>
                    <x-input.text id="name" wire:model.live="register.name" placeholder="Name"/>
                    <x-input.error for="register.name"/>
                </div>

                <div class="space-y-1">
                    <x-input.label value="Email"/>
                    <x-input.text id="email" wire:model.live="register.email" placeholder="Email"/>
                    <x-input.error for="register.email"/>
                </div>

                <div class="space-y-1">
                    <x-input.label value="Password"/>
                    <x-input.text type="password" id="password" wire:model.live="register.password" placeholder="Password"/>
                    <x-input.error for="register.password"/>
                </div>

                <div class="space-y-1">
                    <x-input.label value="Password Confirmation"/>
                    <x-input.text type="password" id="password-confirmation" wire:model.live="register.password_confirmation"
                                  placeholder="Password Confirmation"/>
                    <x-input.error for="register.password_confirmation"/>
                </div>
            </div>
        </x-slot>
        <x-slot name="footer">
            <x-form.button wire:click="register" wire:target="register">Register</x-form.button>
        </x-slot>
    </x-dialog-modal>
</div>

@push('scripts')
    <script src="https://js.stripe.com/v3/"></script>
@endpush
