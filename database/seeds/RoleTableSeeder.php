<?php

use Illuminate\Database\Seeder;
Use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = [
        [
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'See only Listing Of Role'
        ],
        [
            'name' => 'guest',
            'display_name' => 'Guest',
            'description' => 'See only Listing'
        ],
        [
            'name' => 'patient',
            'display_name' => 'Patient',
            'description' => 'can view default + records & view diabetes'
        ]
        
        ];
        foreach ($role as $key => $value) {
            Role::create($value);
        }
    }
}
