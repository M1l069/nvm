<?php

namespace App\Http\Traits;

use App\Models\User;
use Illuminate\Support\Str;

trait GeneratesUsernames
{
    protected function generateUsername(string $firstName, string $lastName): string {
        $firstName = Str::ascii(Str::lower($firstName));
        $lastName = Str::ascii(Str::lower($lastName));

        $firstName = preg_replace('/[^a-z]/', '', $firstName);
        $lastName = preg_replace('/[^a-z]/', '', $lastName);

        $baseUsername = 'x' . $lastName;

        if (!User::where('username', $baseUsername)->exists()) {
            return $baseUsername;
        }

        for ($i = 1; $i <= strlen($firstName); $i++) {
            $username = $baseUsername . substr($firstName, 0, $i);

            if (!User::where('username', $username)->exists()) {
                return $username;
            }
        }

        $counter = 1;

        do {
            $username = $baseUsername . $firstName . $counter;
            $counter++;
        } while (User::where('username', $username)->exists());

        return $username;
    }
}
