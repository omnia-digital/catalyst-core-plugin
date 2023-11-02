@extends('catalyst::livewire.layouts.pages.full-page-layout')

@section('content')
    <div x-data="" class="">
        <div class="mt-0">
            <x-catalyst::page-heading>
                <x-slot name="title">{{ Translate::get('Membership') }}</x-slot>
                Manage your membership plan and billing information.
            </x-catalyst::page-heading>

            <!-- Subscriptions Settings -->
            <div class="mt-6 space-y-6">
                <div class="grid grid-cols-4 items-center max-w-3xl">
                    <div class="col-span-2 px-2 py-4">
                        <p>Subscriptions Status</p>
                    </div>
                    <div class="col-span-1 px-2 py-4">
                        @if ($this->subscriptionActive)
                            <span class="inline-flex items-center px-4 py-px rounded-full font-bold text-white bg-success-600">Active</span>
                        @else
                            <span class="inline-flex items-center px-4 py-px rounded-full font-bold text-white bg-danger-600">Inactive</span>
                        @endif
                    </div>
                    <div class="col-span-1 px-2 py-4">
                        @if ($this->subscriptionActive)
                            <a role="button" wire:click="confirmSubscriptionCancellation"
                               class="font-semibold text-primary hover:underline whitespace-nowrap">Cancel
                                Subscriptions</a>
                        @else
                            <a role="button" x-on:click.prevent="$openModal('subscription-form')"
                               class="font-semibold text-primary hover:underline whitespace-nowrap">New
                                Subscriptions</a>
                        @endif
                    </div>

                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>Email Address</p>
                    </div>
                    <div class="col-span-2 px-2 py-4 border-t">
                        <p>{{ $this->user->email }}</p>
                    </div>

                    @if ($this->subscriptionActive)
                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>Plan</p>
                        </div>
                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>{{ $subscription?->type?->name ?? 'N/A' }}</p>
                        </div>

                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>Amount</p>
                        </div>
                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>{{ $subscription?->type?->printAmount() ?? 'N/A' }}</p>
                        </div>

                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>Payment Method</p>
                        </div>
                        <div class="col-span-1 px-2 py-4 border-t flex items-center">
                            <x-fas-credit-card class="mr-2 h-8 w-8" aria-hidden="true"/>
                            <span class="mr-2">{{ $subscription?->card_type }}</span>
                            <span class="mr-2">{{ $subscription?->last_4 ?? 'N/A' }}</span>
                        </div>
                        <div class="col-span-1 px-2 py-4">
                            <a role="button"
                               x-on:click.prevent="$openModal('payment-method-form')"
                               class="font-semibold text-primary hover:underline whitespace-nowrap"
                            >Change Payment Method</a>
                        </div>

                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>Next Invoice</p>
                        </div>
                        <div class="col-span-2 px-2 py-4 border-t">
                            <p>{{ $subscription?->next_invoice_at?->toFormattedDateString() ?? 'N/A' }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Cancel Subscriptions Confirmation Modal -->
        <catalyst::x-confirmation-modal wire:model.live="confirmingSubscriptionCancellation">
            <x-slot name="title">
                {{ Translate::get('Cancel Subscriptions') }}
            </x-slot>

            <x-slot name="content">
                {{ Translate::get('Are you sure you would like to cancel your subscription?') }}
            </x-slot>

            <x-slot name="footer">
                <catalyst::x-secondary-button wire:click="$toggle('confirmingSubscriptionCancellation')"
                                    wire:loading.attr="disabled">
                    {{ Translate::get('Cancel') }}
                </catalyst::x-secondary-button>

                <catalyst::x-danger-button class="ml-2" wire:click="cancelSubscription" wire:loading.attr="disabled">
                    {{ Translate::get('Confirm') }}
                </catalyst::x-danger-button>
            </x-slot>
        </catalyst::x-confirmation-modal>
    </div>
@endsection
@push('modals')
    <x-library::modal id="subscription-form" maxWidth="4xl" hideCancelButton>
        <x-slot name="title">{{ Translate::get('New Subscriptions') }}</x-slot>

        <x-slot name="content">
            <iframe src="{{ $this->iFrameURL($subscriptionForm) }}" width="100%" height="100%" frameborder="0"></iframe>
            <script src="//tfaforms.com/js/iframe_resize_helper.js"></script>
        </x-slot>
    </x-library::modal>
    <x-library::modal id="payment-method-form" maxWidth="4xl" hideCancelButton>
        <x-slot name="title">{{ Translate::get('Change Payment Method') }}</x-slot>

        <x-slot name="content">
            <iframe src="{{ $this->iFrameURL($paymentMethodForm) }}" width="100%" height="100%"
                    frameborder="0"></iframe>
            <script src="//tfaforms.com/js/iframe_resize_helper.js"></script>
        </x-slot>
    </x-library::modal>
@endpush
