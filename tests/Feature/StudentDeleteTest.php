<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentDeleteTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_student(): void
    {
        $admin = User::factory()->create([
            'username' => 'deladmin',
            'role' => 'admin',
            'is_active' => true,
        ]);

        $student = User::factory()->create([
            'username' => 'delstudent',
            'role' => 'student',
            'is_active' => true,
            'name' => 'Delete Me',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.students.destroy', $student));

        $response->assertRedirect(route('admin.students.index'));
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', ['id' => $student->id]);
    }
}
