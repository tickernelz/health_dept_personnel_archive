<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'nip' => ['nullable', 'numeric', 'max:255', Rule::unique(User::class)],
            'nama' => ['required', 'string', 'max:255'],
            'email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'hp' => ['nullable', 'numeric', 'max:255', Rule::unique(User::class)],
            'username' => ['required', 'string', 'max:255', Rule::unique(User::class)],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'nip' => $input['nip'],
            'nama' => $input['nama'],
            'email' => $input['email'],
            'hp' => $input['hp'],
            'username' => $input['username'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
