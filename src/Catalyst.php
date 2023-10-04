<?php

namespace OmniaDigital\CatalystCore;

use Carbon\CarbonTimeZone;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use NumberFormatter;
use OmniaDigital\CatalystCore\Settings\BillingSettings;
use OmniaDigital\CatalystCore\Settings\GeneralSettings;
use OmniaDigital\CatalystCore\Support\Translate;

//use Nwidart\Modules\Facades\Module;

class Catalyst
{
    // General Settings //

    public static function hasGeneralSettingEnabled($setting)
    {
        return (new GeneralSettings)->{$setting} === true;
    }

    public static function applyButtonText()
    {
        return Translate::get(self::getGeneralSetting('teams_apply_button_text') ?? 'Apply');
    }

    public static function getGeneralSetting($setting)
    {
        return (new GeneralSettings)->{$setting};
    }

    public static function getTeamsWordUpper()
    {
        return ucfirst(self::getTeamsWord());
    }

    public static function getTeamsWord()
    {
        return Translate::get('teams');
    }

    public static function getTeamsLetter()
    {
        return lcfirst(substr(self::getTeamsWord(), 0, 1));
    }

    public static function getUsersLetter()
    {
        return lcfirst(substr(self::getUsersWord(), 0, 1));
    }

    public static function getUsersWord()
    {
        return Translate::get('users');
    }

    //Billing Settings //
    public static function getAppFee()
    {
        return self::getBillingSetting('application_fee_percent') ?? config('billing.team_member_subscriptions.application_fee_percent');
    }

    public static function getBillingSetting($setting)
    {
        return (new BillingSettings)->{$setting};
    }

    public static function isUsingUserSubscriptions()
    {
        return self::hasBillingSettingEnabled('user_subscriptions');
    }

    public static function hasBillingSettingEnabled($setting)
    {
        return (new BillingSettings)->{$setting} === true;
    }

    public static function isUsingTeamSubscriptions()
    {
        return self::hasBillingSettingEnabled('team_subscriptions');
    }

    public static function isUsingTeamMemberSubscriptions()
    {
        return self::hasBillingSettingEnabled('team_member_subscriptions');
    }

    public static function isUsingStripe(): bool
    {
        return self::isUsingPaymentGateway('stripe');
    }

    public static function isUsingPaymentGateway($gateway): bool
    {
        return (new BillingSettings)->payment_gateway == $gateway;
    }

    public static function isUsingChargent(): bool
    {
        return self::isUsingPaymentGateway('chargent');
    }

    public static function isAllowingGuestAccess(): bool
    {
        return (new GeneralSettings)->allow_guest_access;
    }

    public static function shouldShowLoginOnGuestAccess(): bool
    {
        return (new GeneralSettings)->should_show_login_on_guest_access;
    }

    public static function isSubscriptionShownInNavigation()
    {
        return self::getBillingSetting('show_user_subscription_plan_in_navigation');
    }

    public static function isSubscriptionShownInProfileHeader()
    {
        return self::getBillingSetting('show_user_subscription_plan_in_profile_header');
    }

    public static function timezoneList()
    {
        foreach (timezone_identifiers_list() as $timezone) {
            $timezones[$timezone] = $timezone . ' ' . CarbonTimeZone::create($timezone)->toOffsetName();
        }

        return $timezones ?? [];
    }

    /**
     * @return bool|string
     */
    public static function money(string $string)
    {
        $amount = new NumberFormatter('en_US', NumberFormatter::CURRENCY);
        $amount->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, 2);

        return $amount->format($string);
    }

    /**
     * Get the list of country.
     *
     * @return array
     */
    public static function countries()
    {
        $countries = [];

//        foreach ((new ISO3166)->all() as $country) {
//            $countries[$country['alpha2']] = $country['name'];
//        }

        return $countries;
    }

    public static function isModuleEnabled($moduleName)
    {
//        $modules = collect(Module::allEnabled());
//
//        $contains = $modules->contains(function ($value, $key) use ($moduleName) {
//            return $moduleName === $value->getLowerName();
//        });
//
//        if ($contains) {
//            return true;
//        }
//
//        return false;
    }

    public function translate($string): string
    {
        $wordsInString = explode(' ', $string);

        $newWordString = '';
        foreach ($wordsInString as $originalWord) {
            $lowercase = strtolower($originalWord);
            $capitalized = ucfirst($originalWord);
            $singular = Str::singular($lowercase);
            $plural = Str::plural($lowercase);
            $newWord = $lowercase;
            if (Lang::has('platform_terms.' . $singular)) {
                $amount = 1;
                if ($lowercase == $plural) {
                    $amount = 2;
                }
                $newWord = trans_choice('platform_terms.' . $singular, $amount);
            }

            // Checks if first letter is capitalized of the original word
            if (ctype_upper(substr($originalWord, 0, 1))) {
                $newWord = ucfirst($newWord);
            } else {
                $newWord = strtolower($newWord);
            }

            $newWordString .= $newWord . ' ';
        }

        $newWordString = rtrim($newWordString);

        return __($newWordString);
    }
}
