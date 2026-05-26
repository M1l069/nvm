<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Department;
use App\Models\Guardian;
use App\Models\Specialization;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@skola.sk',
            'password' => Hash::make('admin'),
            'role' => UserRole::Admin->value,
            'must_change_password' => false
        ]);

        // Vytvorenie žiaka
        $student = User::create([
           'name' => 'Dominik Török',
            'username' => 'xtorok',
            'password' => Hash::make('password'),
            'role' => UserRole::Student->value,
            'must_change_password' => false,
        ]);

        $department = Department::create([
            'name' => 'Hudobný odbor'
        ]);

        $specialization = Specialization::create([
            'name' => 'Gitara',
            'department_id' => $department->id
        ]);

        $teacher = User::create([
            'name' => 'Ján Huba',
            'username' => 'xhuba',
            'password' => Hash::make('password'),
            'role' => UserRole::Teacher->value,
            'must_change_password' => false
        ]);

        $teacher1 = Teacher::create([
            'user_id' => $teacher->id,
            'specialization_id' => $specialization->id,
        ]);

        $department->update([
            'responsible_teacher_id' => $teacher1->id
        ]);

        $studentUser = Student::create([
            'user_id' => $student->id,
            'specialization_id' => $specialization->id,
            'birth_date' => '2016-10-21',
            'street' => 'Námestie hraničiarov',
            'city' => 'Bratislava',
            'postal_code' => '85103',
            'country' => 'Slovensko'
        ]);

        $guardianUser = User::create([
            'name' => 'Jana Töröková',
            'username' => 'xtorokj',
            'email' => 'torokova@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Parent->value,
            'must_change_password' => false
        ]);

        $guardian = Guardian::create([
            'user_id' => $guardianUser->id,
            'phone_number' => '+421904567283'
        ]);

        $guardian->students()->attach($studentUser->id, [
            'relationship' => 'matka',
        ]);
    }
}
