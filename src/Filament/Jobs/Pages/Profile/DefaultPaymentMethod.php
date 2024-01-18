<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Profile;

use Livewire\Component;
use OmniaDigital\CatalystCore\Support\Jobs\Livewire\WithStripe;

class DefaultPaymentMethod extends Component
{
    use WithStripe;

    public function render()
    {
        return view('profile.default-payment-method', [
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }
}
