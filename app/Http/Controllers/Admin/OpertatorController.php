<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;

class OpertatorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.operator.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.operator.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $petugas = User::where('role', 'operator')->where('id', $id)->firstOrFail();
        return view('admin.operator.edit', compact('petugas'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $petugas = User::where('role', 'operator')->where('id', $id)->firstOrFail();

        try {
            if ($petugas) {
                $petugas->delete();
            }

            return redirect()->route('admin.operator.index')->with('success', 'Petugas berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal saat menghapus data petugas.');
        }
    }
}
