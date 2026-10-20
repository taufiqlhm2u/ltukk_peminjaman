<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function loans()
    {
        return $this->hasMany(EquipmentLoan::class);
    }

    public function available() :int
    {
        $borrowedCount = $this->loans->whereIn('status', ['borrowed', 'overdue'])->sum('quantity');
        return $this->stock - $borrowedCount;
    }
}
