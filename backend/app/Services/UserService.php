<?php

namespace App\Services;

use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use InvalidArgumentException;

class UserService
{
    /**
     * Save or update a user
     * 
     * @param array $data data to fill a user
     * 
     * @return \App\User created/updated user
     */
    public function saveUserData(array $data): User
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns|unique:users',
            'password' => 'required|string|min:8|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->assignRole(['customer']);

        return $user;
    }
    
    /**
     * Get API token for user using password and email
     * 
     * @param array $data data to look in
     * 
     * @return array data to be returned
     */
    public function issueApiToken(array $data): string
    {
        $validator = Validator::make($data, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $user = User::firstWhere('email', $data['email']);

        if (is_null($user) || !Hash::check($data['password'], $user->password)) {
            throw new InvalidArgumentException('wrong email or password');
        }

       return $user->createToken('auth-token')->plainTextToken;
    }
}
