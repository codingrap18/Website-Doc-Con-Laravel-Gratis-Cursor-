<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default users
        $admin = User::create([
            'name' => 'System Administrator',
            'email' => 'admin@pertamina.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $docController = User::create([
            'name' => 'Document Controller',
            'email' => 'controller@pertamina.com',
            'password' => bcrypt('password'),
            'role' => 'document_controller',
        ]);

        $reviewer1 = User::create([
            'name' => 'Engineering Reviewer 1',
            'email' => 'reviewer1@pertamina.com',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
        ]);

        $reviewer2 = User::create([
            'name' => 'Engineering Reviewer 2',
            'email' => 'reviewer2@pertamina.com',
            'password' => bcrypt('password'),
            'role' => 'reviewer',
        ]);

        // Create sample documents
        \App\Models\Document::create([
            'document_number' => 'PTA-ENG-001-2024',
            'document_title' => 'Process Flow Diagram - Main Plant',
            'revision' => 'A',
            'status' => 'IFR',
            'submission_date' => now()->subDays(3),
            'target_date' => now()->addDays(2),
            'latest_reviewer_id' => $reviewer1->id,
            'submit_to_reviewer_date' => now()->subDays(3),
            'document_position' => 'Main Engineering',
        ]);

        \App\Models\Document::create([
            'document_number' => 'PTA-ENG-002-2024',
            'document_title' => 'Piping and Instrumentation Diagram',
            'revision' => 'B',
            'status' => 'IFA',
            'submission_date' => now()->subDays(5),
            'target_date' => now()->subDays(1), // Overdue
            'latest_reviewer_id' => $reviewer2->id,
            'submit_to_reviewer_date' => now()->subDays(5),
            'document_position' => 'Process Engineering',
        ]);

        \App\Models\Document::create([
            'document_number' => 'PTA-ENG-003-2024',
            'document_title' => 'Equipment Data Sheet - Pumps',
            'revision' => '0',
            'status' => 'IFC',
            'submission_date' => now()->subDays(10),
            'target_date' => now()->subDays(5),
            'latest_reviewer_id' => $reviewer1->id,
            'submit_to_reviewer_date' => now()->subDays(10),
            'document_position' => 'Mechanical Engineering',
        ]);

        \App\Models\Document::create([
            'document_number' => 'PTA-ENG-004-2024',
            'document_title' => 'Electrical Single Line Diagram',
            'revision' => 'NS',
            'status' => 'NS',
            'submission_date' => null,
            'target_date' => null,
            'latest_reviewer_id' => null,
            'submit_to_reviewer_date' => null,
            'document_position' => 'Electrical Engineering',
        ]);

        // Create sample notifications
        \App\Models\Notification::create([
            'user_id' => $reviewer1->id,
            'title' => 'New Document Assignment',
            'message' => 'Document PTA-ENG-001-2024 has been assigned to you for review.',
            'type' => 'review',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $reviewer2->id,
            'title' => 'Document Overdue',
            'message' => 'Document PTA-ENG-002-2024 is overdue for review.',
            'type' => 'overdue',
            'read_at' => null,
        ]);

        \App\Models\Notification::create([
            'user_id' => $docController->id,
            'title' => 'Welcome to Document Control System',
            'message' => 'Your document controller account has been set up successfully.',
            'type' => 'info',
            'read_at' => now(),
        ]);

        // Create sample document reviews
        \App\Models\DocumentReview::create([
            'document_id' => 3, // Equipment Data Sheet
            'reviewer_id' => $reviewer1->id,
            'status' => 'IFC',
            'revision' => '0',
            'comment' => 'Approved',
            'review_notes' => 'All technical specifications are correct and meet project requirements.',
            'reviewed_at' => now()->subDays(5),
        ]);

        // Create sample transmittal letter
        \App\Models\TransmittalLetter::create([
            'transmittal_number' => 'TL-202408-0001',
            'date' => now(),
            'vendor_name' => 'ABC Engineering Consultants',
            'description' => 'Transmittal of approved engineering documents for construction',
            'document_ids' => [3], // Equipment Data Sheet
            'created_by' => $docController->id,
        ]);
    }
}
