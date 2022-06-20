<?php

namespace App\Http\Controllers\Admin\LoginLocation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginLocationCtrl extends Controller
{
    /**
     * 
     */
    public function viewLoginLocation()
    {
        return view('admin.manage_login_location.manage_login_location'); 
    }
}
