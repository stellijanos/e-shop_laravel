<?php

namespace App\Models;


class Employee extends User
{
    
    public static function getAllEmployees() {
        return self::where('role', '<>', 'customer')->paginate(5);
    }
}
