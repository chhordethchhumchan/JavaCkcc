<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = [
	    [
		'name' => 'role-list',
		'parent_id' => 1,
		'display_name' => 'Display Role Listing',
		'description' => 'See only Listing Of Role'
	    ],
	    [
		'name' => 'role-create',
		'parent_id' => 1,
		'display_name' => 'Create Role',
		'description' => 'Create New Role'
	    ],
	    [
		'name' => 'role-edit',
		'parent_id' => 1,
		'display_name' => 'Edit Role',
		'description' => 'Edit Role'
	    ],
	    [
		'name' => 'role-delete',
		'parent_id' => 1,
		'display_name' => 'Delete Role',
		'description' => 'Delete Role'
	    ],
	    [
		'name' => 'post-list',
		'parent_id' => 2,
		'display_name' => 'Display post',
		'description' => 'See only Listing Of post'
	    ],
	    [
		'name' => 'post-create',
		'parent_id' => 2,
		'display_name' => 'Create post',
		'description' => 'Create New post'
	    ],
	    [
		'name' => 'post-edit',
		'parent_id' => 2,
		'display_name' => 'Edit post',
		'description' => 'Edit post'
	    ],
	    [
		'name' => 'post-delete',
		'parent_id' => 2,
		'display_name' => 'Delete post',
		'description' => 'Delete Post'
	    ]
	];
	foreach ($permission as $key => $value) {
	    Permission::create($value);
	}
    }
}
