<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {
        // requires input, min length of 8, max length of 100, and at least 1 lowercase, 1 uppercase, 1 number, and 1 special character
        return ['required',
            'min:8',
            'max:100',
            'string',
            'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^\w])).+$/',
            new Password,
            'confirmed'];
    }
}
