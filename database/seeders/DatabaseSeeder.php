<?php

namespace Database\Seeders;

use App\Enums\EventType;
use App\Enums\UserRole;
use App\Models\Band;
use App\Models\Department;
use App\Models\Event;
use App\Models\Guardian;
use App\Models\Room;
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
            'username' => 'xtorokova',
            'email' => 'torokova@example.com',
            'password' => Hash::make('password'),
            'role' => UserRole::Parent->value,
            'must_change_password' => false
        ]);

        $guardian = Guardian::create([
            'user_id' => $guardianUser->id,
            'phone_number' => '+421904567283'
        ]);

        $guardian->students()->attach($studentUser->id);

        $room = Room::create([
            'name' => 'Koncertná hala 1',
            'capacity' => 350,
            'description' => "Hlavná koncertná hala až pre 350 ľudí s veľkým javiskom."
        ]);

        $event = Event::create([
            'teacher_id' => $teacher1->id,
            'name' => 'Koncert',
            'type' => EventType::Concert->value,
            'starts_at' => '2026-06-13 12:00:00',
            'ends_at' => '2026-06-13 13:00:00',
            'room_id' => $room->id,
            'capacity' => $room->capacity,
            'description' => "Koncert našej školskej kapely, kde ukážu svoj talent
            a nadobudnuté znalosti.",
            'is_public' => true,
        ]);

        $band = Band::create([
            'teacher_id' => $teacher1->id,
            'name' => 'Školská kapela',
            'capacity' => 30,
            'description' => "Kapela zložená pri založení školy. V kapele je 30 miest a sú v nej len tí najlepší."
        ]);
        $band->students()->attach($studentUser->id);
        $event->participants()->attach($guardian->user->id);
        $event->bands()->attach($band->id);

    }
}
