<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edition;
use App\Models\Author;

class EditionsShop extends Controller
{

    public function index(Request $request) {
        $query = Edition::query();

        if ($request->has('title')) {
            $query->where('title', 'like', '%' . $request->get('title') . '%');
        }

        if ($request->has('author')) {

        }
    }

}
