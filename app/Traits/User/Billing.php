<?php

namespace App\Traits\User;

trait Billing
{
    public function setStripeId($stripeId): void
    {
        $this->stripe_id = $stripeId;
        $this->save();
    }

    public function getStripeId()
    {
        return $this->stripe_id;
    }

    public function setDefaultCardDetails($lastFour, $type = 'card')
    {
        $this->pm_type;
        $this->pm_last_four = $lastFour;
        $this->save();
    }
}
