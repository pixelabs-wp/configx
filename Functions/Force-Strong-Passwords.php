<?php
/*
  Title: Force Strong Passwords
  Category: Security
  Description: Add description here
*/

function force_strong_passwords($errors, $user_login, $user_password) {
    $min_length = 8; // Minimum password length
    $min_uppercase = 1; // Minimum number of uppercase letters
    $min_lowercase = 1; // Minimum number of lowercase letters
    $min_numbers = 1; // Minimum number of digits
    $min_special_chars = 1; // Minimum number of special characters

    // Check password length
    if (strlen($user_password) < $min_length) {
        $errors->add('password_length', sprintf(__('Password must be at least %d characters long.'), $min_length));
    }

    // Check for uppercase letters
    if (preg_match_all('/[A-Z]/', $user_password) < $min_uppercase) {
        $errors->add('password_uppercase', sprintf(__('Password must contain at least %d uppercase letter(s).'), $min_uppercase));
    }

    // Check for lowercase letters
    if (preg_match_all('/[a-z]/', $user_password) < $min_lowercase) {
        $errors->add('password_lowercase', sprintf(__('Password must contain at least %d lowercase letter(s).'), $min_lowercase));
    }

    // Check for digits
    if (preg_match_all('/[0-9]/', $user_password) < $min_numbers) {
        $errors->add('password_numbers', sprintf(__('Password must contain at least %d digit(s).'), $min_numbers));
    }

    // Check for special characters
    if (preg_match_all('/[^a-zA-Z0-9]/', $user_password) < $min_special_chars) {
        $errors->add('password_special_chars', sprintf(__('Password must contain at least %d special character(s).'), $min_special_chars));
    }

    return $errors;
}

add_filter('wp_check_password', 'force_strong_passwords', 10, 3);


?>