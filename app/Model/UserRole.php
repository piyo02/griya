<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'role_user';
    public $timestamps = false;
    protected $fillable = [
		'user_id', 'role_id'
	];
    // /*
    // * Method untuk yang mendefinisikan relasi antara model user dan model Role
    // */ 
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}