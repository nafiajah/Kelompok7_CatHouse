<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catdata;

class CathouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $login = Catdata::all();
        return view('login', compact('login'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('register.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|enum:admin,user|',
            'username'     => 'required|string|unique|max:50',
            'password'   => 'required|string',
            'nama_pelanggan'        => 'required|string|max:50',
            'email'        => 'required|email|unique|max:100',
            'no_telp'        => 'required|string|max:50',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
