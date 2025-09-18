<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TopController extends Controller
{
    public function showTop()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin.top', compact('admin'));
    }
}
