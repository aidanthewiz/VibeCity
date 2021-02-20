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
        // requires input, min length of 8, and at least 1 uppercase, 1 number, and 1 special character
        return ['required', 'string', (new Password)->length(8)->requireUppercase()->requireNumeric()->requireSpecialCharacter(), 'confirmed'];
    }
}
