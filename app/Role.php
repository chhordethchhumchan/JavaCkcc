<?php 
namespace App;
use Zizaco\Entrust\EntrustRole;
//use Illuminate\Database\Eloquent\Model;
class Role extends EntrustRole
{
	protected $table = 'roles';
	protected $fillable = [
		'name',
		'display_name'
	];
}