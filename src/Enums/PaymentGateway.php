<?php

namespace OmniaDigital\CatalystCore\Enums;

enum PaymentGateway: string
{
    case Chargent = 'chargent';
    case Stripe = 'stripe';
}
