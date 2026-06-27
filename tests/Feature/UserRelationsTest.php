<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Role;
use App\Models\Jabatan;
use App\Models\UnitKerja;
use App\Listeners\IamAuthenticatedListener;
use Juniyasyos\IamClient\Events\IamAuthenticated;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserRelationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Since we have a fresh DB, create standard entries
        $this->role = Role::create(['nama_role' => 'Admin']);
        $this->jabatan = Jabatan::create(['nama_jabatan' => 'Kepala']);
        $this->unitKerja = UnitKerja::create(['unit_name' => 'IT Department', 'slug' => 'it-dept']);
        
        $this->user = User::create([
            'NIK' => '123456',
            'name' => 'John Doe',
            'password' => Hash::make('password')
        ]);
    }

    public function test_user_can_sync_relations_to_pivot_tables()
    {
        $this->user->roles()->sync([$this->role->id_role]);
        $this->user->jabatans()->sync([$this->jabatan->id_jabatan]);
        $this->user->unitKerjas()->sync([$this->unitKerja->id]);

        // Assert relationships
        $this->assertEquals(1, $this->user->roles()->count());
        $this->assertEquals(1, $this->user->jabatans()->count());
        $this->assertEquals(1, $this->user->unitKerjas()->count());
    }

    public function test_backward_compatibility_accessors_work_correctly()
    {
        $this->user->roles()->sync([$this->role->id_role]);
        $this->user->jabatans()->sync([$this->jabatan->id_jabatan]);
        $this->user->unitKerjas()->sync([$this->unitKerja->id]);

        // Refresh to get fresh relations
        $user = User::with(['roles', 'jabatans', 'unitKerjas'])->find($this->user->id_user);

        // Assert properties (testing accessors)
        $this->assertEquals('Admin', $user->role);
        $this->assertEquals('Kepala', $user->jabatan);
        $this->assertEquals('IT Department', $user->unit_kerja);

        // Assert id properties (testing accessors)
        $this->assertEquals($this->role->id_role, $user->id_role);
        $this->assertEquals($this->jabatan->id_jabatan, $user->id_jabatan);
        $this->assertEquals($this->unitKerja->id, $user->id_unit_kerja);
    }

    public function test_iam_authenticated_listener_syncs_pivot_tables()
    {
        // Mock payload from IAM Server
        $payload = [
            'roles' => ['Admin'],
            'unit_kerja' => ['name' => 'IT Department']
        ];

        // Ensure user currently has no roles
        $this->assertEquals(0, $this->user->roles()->count());

        // Dispatch Listener Manually
        $event = new IamAuthenticated($this->user, $payload, 'web');
        $listener = new IamAuthenticatedListener();
        $listener->handle($event);

        // Reload user to verify pivot tables were populated
        $this->user->refresh();
        $this->assertEquals(1, $this->user->roles()->count());
        $this->assertEquals('Admin', $this->user->role);
        $this->assertEquals('IT Department', $this->user->unit_kerja);
    }
    
    public function test_wherehas_queries_work_for_surat_masuk()
    {
        $this->user->jabatans()->sync([$this->jabatan->id_jabatan]);

        // Query test exactly like SuratMasukController
        $foundUser = User::whereHas('jabatans', function ($q) {
            $q->where('jabatans.id_jabatan', $this->jabatan->id_jabatan);
        })->first();

        $this->assertNotNull($foundUser);
        $this->assertEquals($this->user->id_user, $foundUser->id_user);
    }
}
