<?php

namespace Iscapsgt09;

use Illuminate\Foundation\Auth\User as Authenticatable;

use DateTime;

class User extends Authenticatable
{
    const MALE = 'm';
    const FEMALE = 'f';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function getAge() {
        $birthDate = new DateTime($this->birth_date);
        $today = new DateTime('now');

        return $today->diff($birthDate)->y;
    }
    public function is($gender) {
        return ($this->gender == strtolower($gender));
    }
}
