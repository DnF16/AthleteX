<?php

require 'bootstrap/app.php';

$app = app();

// Get the database connection
$db = $app->make('db');

// Query users
$users = $db->table('users')->get(['id', 'name', 'email', 'role']);

echo "=== Users in Database ===\n";
foreach ($users as $user) {
    echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role}\n";
}
echo "\nTotal users: " . count($users) . "\n";
