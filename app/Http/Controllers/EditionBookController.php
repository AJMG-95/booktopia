<?php

namespace App\Http\Controllers;

use App\Models\EditionBook;
use Illuminate\Http\Request;


class EditionBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function list()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EditionBook $editionBook)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EditionBook $editionBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EditionBook $editionBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EditionBook $editionBook)
    {
        //
    }

    /**
     * Obtiene una colección de libros aleatorios que son deseos de los usuarios.
     *
     * @return \Illuminate\Support\Collection
     */
    public function randomBooks() {
        $randomBooks = EditionBook::where('visible', true)
                        ->inRandomOrder()
                        ->get();

        return $randomBooks ? $randomBooks->take(10) : collect();
    }

}
