<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $customerRole = Role::create([
            'name' => 'customer'
        ]);

        $owner = User::create(
            [
                'name' => "Admin",
                'email' => 'admin@olsop.com',
                'password' => bcrypt('123'),
            ],
        );
        $owner->assignRole($ownerRole);

        $customer = User::create(
            [
                'name' => "Pembeli",
                'email' => 'pembeli@email.com',
                'password' => bcrypt('123'),
                'province_id' => 5,
                'city_id' => 39,
                'address' => "Kota Gede, Yogyakarta",
                'postal_code' => "57432",
                'phone_number' => "081234567890",
                'email_verified_at' => now(),
            ],
        );
        $customer->assignRole($customerRole);
    }
}
