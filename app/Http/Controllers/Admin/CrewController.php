<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;

class CrewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.crew.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.crew.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kru = User::where('role', 'crew')->where('id', $id)->firstOrFail();

        return view('admin.crew.edit', compact('kru'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kru = User::where('role', 'crew')->where('id', $id)->firstOrFail();

        try {
            $kru->delete();

            return redirect()->route('admin.crew.index')->with('success', 'Kru berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal saat menghapus data kru.');
        }
    }
}
