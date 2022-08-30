<?php

namespace App\Validation;

use App\Models\ModelUser;

class Userrules
{
    /**
     * Validate whether the user already exist in database or hasn't
     */
    public function validateUser(string $str, string $fields, array $input)
    {
        $modelUser = new ModelUser();
        $data = $modelUser->where('email', $input['email'])->first();

        if (!$data) {
            return false;
        }

        return password_verify($input['password'], $data['password']);
    }

    /** 
     * Check if email is exist in database.
     * if exist, return true
     */
    public function is_exist(string $str, string $fields, array $data)
    {
        $modelUser = new ModelUser();
        $user = $modelUser->where('email', $data['email'])->first();

        if (!$user) {
            return false;
        }

        return true;
    }
}
