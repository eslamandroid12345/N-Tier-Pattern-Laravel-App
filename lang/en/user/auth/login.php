<?php

return [
    /*
    |--------------------------------------------------------------------------
    | SERVICE FUNCTIONS MESSAGES
    |--------------------------------------------------------------------------
    */
    'account_inactive'        => 'User account is inactive. Please contact admin support.',
    'code_sent'               => 'Verification code sent successfully. Please check your SMS.',
    'invalid_credentials'     => 'The provided credentials are incorrect.',
    'login_success'          => 'User logged in successfully.',
    'register_code_sent'     => 'Code sent successfully, please check your SMS.',
    'code_resent'            => 'Verification code resent successfully.',
    'profile_get_success'    => 'Profile data retrieved successfully.',
    'password_updated'       => 'Password updated successfully.',
    'profile_update_success' => 'Profile data updated successfully.',
    'logout_success'         => 'User logged out successfully.',
    'welcome_back'           => 'Welcome back.',

    /*
    |--------------------------------------------------------------------------
    | EXCEPTION MESSAGES
    |--------------------------------------------------------------------------
    */
    'failed_login'            => 'Failed to login with phone number.',
    'otp_not_found'           => 'OTP for this user does not exist or has expired.',
    'verify_error'            => 'OTP verification failed.',
    'register_failed'         => 'User registration failed.',
    'code_resend_failed'      => 'Failed to generate a new verification code.',
    'profile_get_failed'      => 'Failed to load profile data.',
    'old_password_incorrect'  => 'Current password is not correct.',
    'same_password'           => 'The new password cannot be the same as the old password.',
    'password_update_failed'  => 'Password not updated.',
    'profile_update_failed'   => 'Failed to update profile.',
    'logout_failed'           => 'Failed to log out.',
    'supervisor_activation'   => 'Please contact your supervisor to activate your account.',
    'login_credentials_error' => 'Invalid login credentials. Please verify your details and try again.',
    'login_process_error'     => 'An error occurred while processing the request. Please try again.',
    'logout_process_error'    => 'An error occurred during logout. Please try again.',

    /*
    |--------------------------------------------------------------------------
    | AUTH VALIDATION MESSAGES
    |--------------------------------------------------------------------------
    */
    'phone' => [
        'required' => 'The phone field is required.',
        'numeric'  => 'The phone must be a valid number.',
        'exists'   => 'The selected phone does not exist.',
    ],
    'email' => [
        'required' => 'The email field is required.',
        'email'    => 'Please provide a valid email address.',
        'exists'   => 'The selected email does not exist.',
    ],
    'password' => [
        'required' => 'The password field is required.',
    ],
];
