<?php

namespace App\Services;

use App\Models\Company;
use App\Models\User;

class Communication
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function between($user_id, $company_id, $type = 'company') {
        $user = User::find($user_id);
        $company = Company::find($company_id);

        // First index is sender, and second index is for receiver
        return [ $type === "user" ? $user : $company, $type === 'company' ? $user : $company ];
    }
}
