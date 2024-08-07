<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Employee extends User
{
    
    public static function getAllEmployees() {
        return self::where('role', '<>', 'customer')->paginate(5);
    }

}
