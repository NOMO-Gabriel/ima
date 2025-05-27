<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            AcademySeeder::class,
            DepartmentSeeder::class,
            CenterSeeder::class,
            CitySeeder::class,
            PhaseSeeder::class,
            FormationSeeder::class,
            CourseSeeder::class,
            RoomSeeder::class,
            TimetableSeeder::class,
            SlotSeeder::class,
            EntranceExamSeeder::class,
            IcorpSeeder::class,
            MaterialSeeder::class,
            EnrollmentSeeder::class,
            AbsenceSeeder::class,
            EntranceExamFormationSeeder::class,
            BookSeeder::class,
            ExamSeeder::class,
            CommandSeeder::class,
            ExamTypeSeeder::class,
            FormationBookSeeder::class,
            CommandUnitSeeder::class,
            NoteSeeder::class,
            TransactionSeeder::class,
            CourseFormationSeeder::class,
            StaffSeeder::class,
            TeacherSeeder::class,
            StudentSeeder::class,
            MockExamSeeder::class,
            RegistrationSeeder::class,
            TransactionHistorySeeder::class,
            HistorySeeder::class,
            BookletSeeder::class,
            RolesAndPermissionsSeeder::class,
            AssignationSeeder::class,
        ]);
    }
}