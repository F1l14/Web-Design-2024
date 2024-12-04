<?php
// The password you want to hash
$password = "password";

// Define the options for bcrypt hashing
$options = [
    'cost' => 12, // Set the cost factor to 12 rounds
];

// Generate the bcrypt hash
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Output the generated hash
echo "Hashed Password: " . $hashedPassword . "\n";
passGen();

