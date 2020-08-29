<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Model\Role;
use Auth;


class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'username', 'email', 'password',  'role_name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*
    * Method untuk yang mendefinisikan relasi antara model user dan model Role
    */ 
    public function roles()
    {
        // dd( "aaa" );die;
        return $this->belongsToMany(Role::class);
    }
    /*
    * Method untuk menambahkan role (hak akses) baru pada user
    */ 
    public function putRole($role)
    {
        if (is_string($role))
        {
            $role = Role::whereRoleName($role)->first();
        }
        return $this->roles()->attach($role);
    }
    /*
    * Method untuk menghapus role (hak akses) pada user
    */ 
    // public function forgetRole($role)
    public function forgetRole()
    {
        // if (is_string($role))
        // {
        //     $role = Role::whereRoleName($role)->first();
        // }
        $roles = Role::get();

        return $this->roles()->detach($roles);
    }
    /*
    * Method untuk mengecek apakah user yang sedang login punya hak akses untuk mengakses page sesuai rolenya
    */ 
    public function hasRole($roleName)
    {
        foreach ($this->roles as $role)
        {
            if ($role->role_name === $roleName) return true;
        }
            return false;
    }

    public static function getFormData( $isEditMode = TRUE )
    {
        $role = new Role();
        if( Auth::user()->roles()->first()->role_name != 'admin' )
        {
            $role = $role->where('roles.role_name',"!=", 'admin' );
        }
        $roles =  $role->get();
        $roleSelect = [];
        foreach( $roles as $role )
        {
            $roleSelect[ $role->id ] = $role->role_name;
        }
        // dd(  );
        $form =  [
            'id' => [
                'type' => 'hidden',
            ],
            'name' => [
                'type' => 'text',
                'label' => 'Nama',
            ],
            'email' => [
                'type' => 'text',
                'label' => 'Email',
            ],
            'role_name' => [
                'type' => 'text',
                'label' => 'Role',
            ],
            'role' => [
                'type' => 'select',
                'label' => 'Role',
                'options' => $roleSelect,
            ],
            '_password' => [
                'type' => 'password',
                'label' => 'Password',
            ],
            '_password_confirmation' => [
                'type' => 'password',
                'label' => 'Konfirmasi Password',
            ],
        ];

        if( $isEditMode )
        {
            // unset( 'role_name', $form );
            unset( $form["role_name"] );
        }else{
            unset( $form["role"] );
            unset( $form["_password"] );
            unset( $form["_password_confirmation"] );
        }

        return $form;
    }
}
