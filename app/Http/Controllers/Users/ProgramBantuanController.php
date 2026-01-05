<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\ProgramBantuan;
use Illuminate\Http\Request;

class ProgramBantuanController extends Controller
{
    public function index()
    {
        $programs = ProgramBantuan::latest()->get();
        return view('users.program_bantuan.index', compact('programs'));
    }
}
