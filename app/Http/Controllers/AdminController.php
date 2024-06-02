<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index() {
        return view('admin.index');
    }   


    public function employees() {

        $employees = User::where('role', '<>' , 'customer')->get();

        return view('admin.employees.index',[
            'employees' => $employees
        ]);
    }
}
