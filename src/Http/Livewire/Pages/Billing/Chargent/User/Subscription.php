<?php

namespace OmniaDigital\CatalystCore\Http\Livewire\Pages\Billing\Chargent\User;

use OmniaDigital\CatalystCore\Facades\Catalyst;
use Livewire\Component;
use OmniaDigital\CatalystCore\Actions\Salesforce\CreateContactObjectAction;
use OmniaDigital\CatalystCore\Actions\Salesforce\GetChargentOrderInfoAction;
use OmniaDigital\CatalystCore\Actions\Salesforce\StopRecurringBillingOnChargentOrderAction;
use OmniaDigital\CatalystCore\Models\FormAssemblyForm;

class Subscription extends Component
{
    public $subscriptionForm;
    public $paymentMethodForm;

    /**
     * Indicates if the application is confirming to cancel a subscription.
     *
     * @var bool
     */
    public $confirmingSubscriptionCancellation = false;

    protected $listeners = ['modal-closed' => '$refresh'];

    public function mount()
    {
        $platformIsUsingChargentPaymentGateway = Catalyst::isUsingPaymentGateway('chargent');
        if (! $platformIsUsingChargentPaymentGateway || ! config('forrest.credentials.consumerKey')) {
//            $this->redirect(route('social.home'));
        }

        $subscriptionFormSlug = Catalyst::getBillingSetting('user_subscription_form');
        $changePaymentFormSlug = Catalyst::getBillingSetting('change_payment_method_form');

        $this->subscriptionForm = FormAssemblyForm::findBySlug($subscriptionFormSlug);
        $this->paymentMethodForm = FormAssemblyForm::findBySlug($changePaymentFormSlug);

        (new CreateContactObjectAction)->execute($this->user);
        $this->user->refresh();

        if ($this->subscription) {
            (new GetChargentOrderInfoAction)->execute($this->subscription);
            $this->subscription->refresh();
        }
    }

    /**
     * Confirm that the user wants to cancel their subscription.
     *
     * @return void
     */
    public function confirmSubscriptionCancellation()
    {
        $this->confirmingSubscriptionCancellation = true;
    }

    public function cancelSubscription()
    {
        (new StopRecurringBillingOnChargentOrderAction)->execute($this->subscription);
        $this->subscription->refresh();

        $this->confirmingSubscriptionCancellation = false;
    }

    public function getSubscriptionActiveProperty()
    {
        return $this->subscription?->is_active;
    }

    public function getSubscriptionProperty()
    {
        return $this->user->chargentSubscription()
            ->latest()
            ->first();
    }

    public function getUserProperty()
    {
        return auth()->user();
    }

    public function iFrameURL(FormAssemblyForm $form)
    {
        $qs = '?';
        $attributes = [];
        $tfaFields = $form->fields()
            ->where('enabled', 1)
            ->pluck('name', 'tfa_code');

        foreach ($tfaFields as $code => $attribute) {
            if ($attribute === 'chargent_order_id' && ! is_null($this->subscription)) {
                $attributes[$code] = $this->subscription?->$attribute;

                continue;
            }
            $attributes[$code] = $this->user->$attribute;
        }

        $qs .= http_build_query($attributes);

        return 'https://tfaforms.com/' . $form->fa_form_id . $qs;
    }

    public function render()
    {
        return view('billing::livewire.pages.billing.chargent.user.subscription', [
            'subscription' => $this->subscription,
        ]);
    }
}
