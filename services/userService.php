<?php

/**
 * Author: Soulaimane Yahya
 * Date: 2023-03-14
 */

/**
 * Find a user by their username in the database.
 *
 * @param PDO $pdo The PDO connection object.
 * @param string $username The username to search for.
 * @return array|null The user data if found, or null if the user doesn't exist.
 */
function findUserByUsername(PDO $pdo, string $username): ?array
{
    $statement = $pdo->prepare('SELECT * FROM users WHERE username = :username');
    $statement->bindValue(':username', $username, PDO::PARAM_STR);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Return null if no user found, otherwise return user array
    return $user ?: null;
}

/**
 * Update the user's name in the database.
 *
 * @param PDO $pdo The PDO connection object.
 * @param int $userId The unique ID of the user.
 * @param string $name The new name for the user.
 * @return bool True if the update was successful, false otherwise.
 */
function updateUserName(PDO $pdo, int $userId, string $name): bool
{
    try {
        $stmt = $pdo->prepare("UPDATE users SET name = :name WHERE id = :id");
        $stmt->bindValue(':name', $name, PDO::PARAM_STR);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}

/**
 * Update the user's password in the database.
 *
 * @param PDO $pdo The PDO connection object.
 * @param int $userId The unique ID of the user.
 * @param string $password The new hashed password for the user.
 * @return bool True if the update was successful, false otherwise.
 */
function updateUserPassword(PDO $pdo, int $userId, string $password): bool
{
    try {
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);
        $stmt->bindValue(':id', $userId, PDO::PARAM_INT);

        return $stmt->execute();
    } catch (PDOException $e) {
        return false;
    }
}
