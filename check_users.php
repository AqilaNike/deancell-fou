<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$users = App\Models\User::all();
if ($users->isEmpty()) {
    echo "NO_USERS";
} else {
    foreach($users as $user) {
        echo "ID: {$user->id} | Name: {$user->name} | Email: {$user->email} | Role: {$user->role}\n";
    }
}
