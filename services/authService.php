<?php

/**
 * Hash a password using a secure algorithm.
 *
 * @param string $password The plain text password.
 * @return string The hashed password.
 */
function hashPassword(string $password): string
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify the provided password against the hashed password.
 *
 * @param string $password The plain text password.
 * @param string $hashedPassword The hashed password from the database.
 * @return bool True if the password matches the hash, false otherwise.
 */
function hashPasswordVerify(string $password, string $hashedPassword): bool
{
    return password_verify($password, $hashedPassword);
}

/**
 * Attempt to authenticate the user by verifying their password.
 *
 * @param array $user The user data array from the database.
 * @param string $password The plain text password provided.
 * @return bool True if authentication is successful, false otherwise.
 */
function authAttempt(array $user, string $password): bool
{
    // Ensure user is not null and password verification is successful
    return $user !== null && hashPasswordVerify($password, $user['password']);
}
