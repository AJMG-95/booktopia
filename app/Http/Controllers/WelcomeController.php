<?php
// app/Http/Controllers/WelcomeController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;


class WelcomeController extends Controller
{
public function index()
{
    $randomBooks = Book::inRandomOrder()->take(4)->get();

    return view('welcome', compact('randomBooks'));
}
}
