<?php

namespace App\Policies;

use App\Country;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Country $country)
    {
        info('Policy authorisation requested');
//        would have some logic here of course but this authorises anything provided it is called
        return true;
    }
}
