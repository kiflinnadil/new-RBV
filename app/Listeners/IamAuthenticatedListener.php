<?php

namespace App\Listeners;

use Juniyasyos\IamClient\Events\IamAuthenticated;
use App\Models\Role;
use App\Models\UnitKerja;
use Illuminate\Support\Facades\Log;

class IamAuthenticatedListener
{
    /**
     * Handle the event.
     */
    public function handle(IamAuthenticated $event): void
    {
        $user = $event->user;
        $payload = $event->payload;
        
        $isDirty = false;

        // Map Role
        if (isset($payload['roles']) && is_array($payload['roles']) && count($payload['roles']) > 0) {
            // Ambil role pertama dari array IAM
            $roleName = $payload['roles'][0]; 
            
            $role = Role::where('nama_role', $roleName)->first();
            if ($role) {
                $user->roles()->sync([$role->id_role]);
                $isDirty = true;
            } else {
                Log::warning("Role '{$roleName}' dari IAM tidak ditemukan di database RBV.");
            }
        }

        // Map Unit Kerja
        if (isset($payload['unit_kerja'])) {
            if (isset($event->payload['unit_kerja']['name'])) {
                $unitKerjaName = $event->payload['unit_kerja']['name'];

                $unitKerja = UnitKerja::firstOrCreate(
                    ['unit_name' => $unitKerjaName]
                );

                if ($unitKerja) {
                    $user->unitKerjas()->sync([$unitKerja->id]);
                    $isDirty = true;
                }
            } else {
                Log::warning("Unit Kerja dari IAM tidak memiliki format yang sesuai.");
            }
        }

        if ($isDirty) {
            $user->save();
        }
    }
}
