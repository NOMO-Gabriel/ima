<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AbsenceSeeder::class,
            AcademySeeder::class,
            AssignationSeeder::class,
            BookSeeder::class,
            BookletSeeder::class,
            CenterSeeder::class,
            CitySeeder::class,
            CommandSeeder::class,
            CommandUnitSeeder::class,
            CourseFormationSeeder::class,
            CourseSeeder::class,
            DepartmentSeeder::class,
            EnrollmentSeeder::class,
            EntranceExamFormationSeeder::class,
            EntranceExamSeeder::class,
            ExamSeeder::class,
            ExamTypeSeeder::class,
            FormationBookSeeder::class,
            FormationSeeder::class,
            HistorySeeder::class,
            IcorpSeeder::class,
            MaterialSeeder::class,
            MockExamSeeder::class,
            NoteSeeder::class,
            PhaseSeeder::class,
            RegistrationSeeder::class,
            RolesAndPermissionsSeeder::class,
            RoomSeeder::class,
            SlotSeeder::class,
            StaffSeeder::class,
            StudentSeeder::class,
            TeacherSeeder::class,
            TimetableSeeder::class,
            TransactionHistorySeeder::class,
            TransactionSeeder::class,
            UserSeeder::class,
        ]);
    }
}