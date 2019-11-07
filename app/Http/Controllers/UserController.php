<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function get() {
        $data = User::all();

        if ($data->isEmpty()) {
            return response()->json('error', 404);
        }

        return response()->json($data, 200);
    }
}
