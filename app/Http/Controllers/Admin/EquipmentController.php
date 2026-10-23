<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.equipment.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.equipment.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $eq = Equipment::findOrFail($id);

        return view('admin.equipment.edit', compact('eq'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $eq = Equipment::findOrFail($id);

        try {
            if ($eq->image) {
                Storage::disk('public')->delete($eq->image);
            }

            $eq->delete();
            return redirect()->route('admin.equipment.index')->with('success', 'Alat berhasil dihapus.');
        } catch (Exception $e) {
            return back()->with('error', 'Gagal saat menghapus data alat.');
        }
    }
}
