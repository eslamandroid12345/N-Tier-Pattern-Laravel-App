<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SERVICE FUNCTIONS MESSAGES
    |--------------------------------------------------------------------------
    */
    'user_update_success' => 'User updated successfully.',
    'user_delete_success' => 'User deleted successfully.',
    'users_get_success' => 'Users retrieved successfully.',


    /*
   |--------------------------------------------------------------------------
   | EXCEPTION MESSAGES
   |--------------------------------------------------------------------------
   */
    'user_delete_failed'  => 'Failed to delete user.',
    'user_update_failed'  => 'Failed to update user.',
    'users_get_failed'  => 'Failed to retrieve users list.',


    /*
    |--------------------------------------------------------------------------
    | USER VALIDATION MESSAGES
    |--------------------------------------------------------------------------
    */
    'user' => [
        'string' => 'The user identifier must be a valid string.',
        'exists' => 'The selected user does not exist or has been deleted.',
    ],
    'image' => [
        'image' => 'The uploaded file must be an image.',
        'mimes' => 'The image must be a file of type: jpg, jpeg, png, or webp.',
        'max'   => 'The image size may not be greater than 2MB.',
    ],
    'first_name' => [
        'required' => 'The first name is required.',
        'string'   => 'The first name must be a valid text string.',
        'max'      => 'The first name must not exceed 100 characters.',
    ],
    'last_name' => [
        'required' => 'The last name is required.',
        'string'   => 'The last name must be a valid text string.',
        'max'      => 'The last name must not exceed 100 characters.',
    ],
    'email' => [
        'required' => 'The email address is required.',
        'string'   => 'The email address must be a valid text string.',
        'email'    => 'Please provide a valid email address.',
        'max'      => 'The email address must not exceed 255 characters.',
        'unique'   => 'This email is already registered.',
    ],
    'phone' => [
        'required' => 'The phone number is required.',
        'numeric'  => 'The phone number must contain only numbers.',
        'unique'   => 'This phone number is already registered.',
    ],
    'password' => [
        'required' => 'The password field is required.',
        'string'   => 'The password must be a valid string.',
        'min'      => 'The password must be at least 8 characters long.',
    ],
    'role_id' => [
        'integer' => 'The role ID must be a valid integer.',
        'exists'  => 'The selected role does not exist.',
    ],
    'national_id' => [
        'integer'        => 'The national ID must be an integer.',
        'digits_between' => 'The national ID must be between 1 and 20 digits.',
        'unique'         => 'This national ID is already registered.',
    ],
    'dark_mode' => [
        'boolean' => 'The dark mode field must be true or false.',
    ],
    'notifications' => [
        'boolean' => 'The notifications field must be true or false.',
    ],
    'language' => [
        'boolean' => 'The language field must be a valid boolean value.',
    ],
    'active' => [
        'boolean' => 'The active status field must be true or false.',
    ],
];
