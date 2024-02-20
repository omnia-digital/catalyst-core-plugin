<?php

namespace OmniaDigital\CatalystCore\Filament\Jobs\Pages\Jobs;

use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;
use Laravel\Jetstream\Jetstream;
use Livewire\WithFileUploads;
use OmniaDigital\CatalystCore\Actions\Fortify\CreateNewUser;
use OmniaDigital\CatalystCore\Data\Jobs\Transaction;
use OmniaDigital\CatalystCore\Events\Jobs\JobPositionWasCreated;
use OmniaDigital\CatalystCore\Facades\Catalyst;
use OmniaDigital\CatalystCore\Filament\Core\Pages\BasePage;
use OmniaDigital\CatalystCore\Models\Jobs\ApplyType;
use OmniaDigital\CatalystCore\Models\Jobs\Coupon;
use OmniaDigital\CatalystCore\Models\Jobs\ExperienceLevel;
use OmniaDigital\CatalystCore\Models\Jobs\HoursPerWeek;
use OmniaDigital\CatalystCore\Models\Jobs\JobPosition;
use OmniaDigital\CatalystCore\Models\Jobs\JobPositionAddon;
use OmniaDigital\CatalystCore\Models\Jobs\JobPositionLength;
use OmniaDigital\CatalystCore\Models\Jobs\PaymentType;
use OmniaDigital\CatalystCore\Models\Jobs\ProjectSize;
use OmniaDigital\CatalystCore\Models\Tag;
use OmniaDigital\CatalystCore\Rules\Jobs\ValidJobAddons;
use OmniaDigital\CatalystCore\Rules\Jobs\ValidTags;
use OmniaDigital\OmniaLibrary\Livewire\WithNotification;

class NewJob extends BasePage
{
    use WithFileUploads, WithNotification;

//    use HasPageShield;

    protected static string $view = 'catalyst::filament.jobs.pages.jobs.new-job';

    protected static bool $shouldRegisterNavigation = true;

    protected static ?string $title = 'Post a New Job';

    public $jobTitle;

    public $description;

    public $team_id = '';

    public $apply_type = '';

    public $apply_value;

    public $payment_type = '';

    public $budget = null;

    public $is_remote = false;

    public $location;

    public $selected_skills = [];

    public $job_position_skill_options = [];

    public $selected_addons = [];

    public $price = 0;

    public $payment_method;

    public $selected_payment_method;

    public $line1;

    public $city;

    public $state;

    public $postal_code;

    public $country;

    public $card_holder_name;

    public $coupon;

    public $validCoupon;

    public $logo;

    public $registerModalOpen = false;

    public $hours_per_week_id;

    public $register = [
        'name',
        'email',
        'password',
        'confirm-password',
    ];

    public $job_length_id;

    public $experience_level_id;

    public $project_size_id;

    public $is_active = false;

    public $default_description = 'The description of the job position will appear here. Write this in the "JobPosition Description" box above.';

    public function mount()
    {
        $this->setTeamId();
        $this->price = Catalyst::getJobSetting('posting_price');
//        abort_unless(auth()->user()->canManageSettings(), 403);

    }

    /**
     * Set current user's company id.
     *
     * @return void
     */
    private function setTeamId()
    {
        $this->team_id = auth()->guest() ? null : auth()->user()->currentTeam->id;
    }

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules());
    }

    private function rules()
    {
        return [
            'jobTitle' => 'required|max:254',
            'description' => 'required|min:50',
            'team_id' => 'required|' . Rule::in(auth()->user()
                    ->allTeams()
                    ->pluck('id')),
            'apply_type' => 'required|' . Rule::in(['link', 'email']),
            'apply_value' => 'required',
            'payment_type' => 'required|' . Rule::in(['hourly', 'fixed']),
            'budget' => 'nullable|numeric|min:0',
            'is_remote' => 'boolean',
            'location' => 'nullable|max:254',
            'selected_skills' => ['required', new ValidTags],
//            'selected_addons' => [new ValidJobAddons],
            'line1' => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'city' => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'country' => 'required_if:selected_payment_method,new-card|nullable|string|size:2',
            'postal_code' => 'required_if:selected_payment_method,new-card|nullable|numeric',
            'state' => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'card_holder_name' => 'required_if:selected_payment_method,new-card|nullable|string|max:254',
            'payment_method' => 'required_if:selected_payment_method,new-card|nullable|string|regex:/^pm/',
            'job_length_id' => 'required',
            'hours_per_week_id' => 'required',
            'project_size_id' => 'required',
            'experience_level_id' => 'required',
            'is_active' => 'boolean',
        ];
    }

    public function updatedLogo()
    {
        $this->validate(['logo' => 'image|max:2048']);
    }

    public function updatedCoupon($value)
    {
        if (!empty($value)) {
            $coupon = Coupon::findByCode($this->coupon);

            if (!$coupon || !$coupon->isValid()) {
                // Re-calculate the total
                $this->price = $this->totalPrice;

                $this->validCoupon = null;
                $this->coupon = null;

                $this->error('The coupon is invalid or expired.');

                return;
            }

            $this->validCoupon = $coupon;

            $this->price = $coupon->afterDiscount($this->totalPrice);

            $this->success('Coupon is applied successfully!');
        }
    }

    public function updatedTeamId()
    {
        $this->switchTeam();
    }

    /**
     * Switch current team to company value.
     */
    private function switchTeam()
    {
        $team = Jetstream::newTeamModel()
            ->find($this->team_id);

        if ($team) {
            return auth()->user()
                ->switchTeam($team);
        }

        $this->error('notify', 'Cannot find the company.');
    }

    /**
     * Show register modal when user click Publish JobPosition without logged in.
     */
    public function showRegisterModal()
    {
        $this->registerModalOpen = true;
    }

    /**
     * A guest can see the form but force him to register an account first.
     */
    public function register()
    {
        $data = array_merge($this->register, ['role' => 'Client']);

        event(new Registered($user = (new CreateNewUser)->create($data)));

        // Login
        resolve(StatefulGuard::class)->login($user);

        // Emit an event to Navigation component to reload the user information.
        $this->dispatch('LoggedIn')->to('navigation');

        // Set the current team is default company.
        $this->setTeamId();

        // Close register modal.
        $this->registerModalOpen = false;

        $this->success('Register an account successfully! You can upload your company logo and add a payment method now.');
    }

    /**
     * Save the job.
     */
    public function save()
    {
        $validated = $this->withValidator(function (Validator $validator) {
            if ($validator->fails()) {
                $this->alertInvalidInput();
                $this->dispatch('validation-fails', errors: $validator->errors());
            }
        })
            ->validate($this->rules());

        // Make sure users have their default payment method.
        // @NOTE - I removed payment for now so job listings are all free
//        if (!auth()->user()
//            ->hasDefaultPaymentMethod()) {
//            $this->error('You have not setup your default payment method yet. Please setup one!');
//
//            return;
//        }

        DB::beginTransaction();

        try {
            // Store logo
            $this->storeLogo();

            $jobAttributes = $validated;
            $jobAttributes['title'] = $validated['jobTitle'];
            // Save job
            $job = JobPosition::create(collect($jobAttributes)
                ->except('selected_skills')
                ->all());

            // Attach maximum 5 skills to job
            $job->skills()
                ->attach(collect($this->selected_skills)
                    ->take(5)
                    ->all());

            // Attach job addons to job
//            $job->addons()
//                ->attach($this->selected_addons);

            // Redeem coupon
            if ($this->coupon) {
                $redeemedCoupon = $job->redeemCoupon($this->coupon, $this->totalPrice);
            }

            // Get the grand total price.
            $price = isset($redeemedCoupon) ? $redeemedCoupon->after_discount_price : $this->totalPrice;

            // Charge via user's default payment method
            // Note: Stripe accepts charges in cents
            if (!empty($price) && $price > 0) {
                $invoice = auth()->user()
                    ->invoiceFor('Publish job: ' . $this->jobTitle, $price * 100);

                // Save a transaction into the database
                $job->transactions()
                    ->create($this->prepareTransaction($invoice)
                        ->all());
            }
        } catch (Exception $exception) {
            DB::rollBack();

            report($exception);

            $this->error('There is an error please contact our support team. Don\'t worry, your card won\'t be charge.');

            throw $exception;
        }

        DB::commit();

        event(new JobPositionWasCreated($job));

        $this->redirectRoute('filament.jobs.pages.job.{job}', [
            'job' => $job,
        ]);
    }

    /**
     * Upload and store logo in database.
     */
    private function storeLogo()
    {
        if ($this->logo) {
            $filename = $this->logo->store('/logos', $this->logoDisk());

            auth()->user()->currentTeam->update(['logo_path' => $filename]);
        }
    }

    /**
     * Get the disk that logo should be stored on.
     *
     * @return string
     */
    private function logoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : 'public';
    }

    /**
     * Prepare transaction to save it into database.
     *
     *
     * @return Transaction
     */
    private function prepareTransaction($invoice)
    {
        $payer = auth()->user();

        return new Transaction(
            gateway: 'Stripe',
            description: 'Publish job: ' . $this->jobTitle,
            transaction_id: $invoice->asStripeInvoice()->charge,
            payer_id: $invoice->asStripeInvoice()->customer,
            payer_name: $invoice->asStripeInvoice()->customer_name ?? $payer->name,
            payer_email: $invoice->asStripeInvoice()->customer_email ?? $payer->email,
            amount: (float)($invoice->asStripeInvoice()->amount_paid / 100),
            invoice_number: $invoice->asStripeInvoice()->id,
            user_id: auth()->id(),
        );
    }

    /**
     * Add/remove addon.
     */
    public function toggleAddon($addonId)
    {
        if (!in_array($addonId, $this->selected_addons)) {
            array_push($this->selected_addons, $addonId);
        } else {
            $key = array_search($addonId, $this->selected_addons);

            if ($key !== false) {
                unset($this->selected_addons[$key]);
            }
        }

        $discount = $this->validCoupon ? $this->validCoupon->discountAmount($this->totalPrice) : 0;

        $this->price = $this->totalPrice - $discount;
    }

    /**
     * Update new payment method.
     */
    public function updatePaymentMethod()
    {
        $user = auth()->user();
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        $this->validate([
            'payment_method' => 'required|string|regex:/^pm/',
        ]);

        $user->updateDefaultPaymentMethod($this->payment_method);

        $this->dispatch('card', [
            'card_brand' => $user->card_brand,
            'card_last_four' => $user->card_last_four,
        ]);

        $this->success('Your payment method was updated! You can publish your job now.');
    }

    /**
     * Sum the addon prices.
     *
     * @return mixed
     */
    public function getAddonsPriceProperty()
    {
        return JobPositionAddon::whereIn('id', $this->selected_addons)
            ->sum('price');
    }

    /**
     * JobPosition posting price + addons.
     *
     * @return mixed
     */
    public function getTotalPriceProperty()
    {
        return Catalyst::getJobSetting('posting_price') + $this->addonsPrice;
    }

    public function getJobPositionSkillOptionsProperty()
    {
        //        return Tag::withType('job_position_skill')->get()->mapWithKeys(fn(Tag $tag) => [$tag->name => ucwords($tag->name)])->all();

        return Tag::getWithType('job_position_skill')->pluck('name', 'id');
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application|mixed[]
     */
    public function getViewData(): array
    {
        return [
            'companies' => auth()->guest() ? [] : auth()->user()
                ->allTeams(),
            'applyTypes' => ApplyType::pluck('name', 'code'),
            'paymentTypes' => PaymentType::pluck('name', 'code'),
            'jobPositionSkillOptions' => $this->jobPositionSkillOptions,
            'addons' => JobPositionAddon::all(),
            'intent' => auth()->guest() ? null : auth()->user()
                ->createSetupIntent(),
            'jobLengths' => JobPositionLength::all(),
            'experienceLevels' => ExperienceLevel::all(),
            'hoursPerWeek' => HoursPerWeek::pluck('value', 'id'),
            'projectSizes' => ProjectSize::orderBy('order')
                ->get()
                ->toArray(),
        ];
    }
}
