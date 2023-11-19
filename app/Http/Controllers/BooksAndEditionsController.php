<?php
// app/Http/Controllers/BooksAndEditionsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BooksAndEditionsController extends Controller
{
    public function index()
    {
        return view('admin.management.books&editions.index');
    }
}
