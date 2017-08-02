<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

class PlayerController extends Controller
{
    public function getAll()
    {
        $users = DB::select('select * from tbl_player');
        return $users;
    }
}
