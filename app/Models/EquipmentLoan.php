<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentLoan extends Model
{
    protected $guarded = [];

    protected $casts = [
        'requested_checkout_date' => 'date',
        'expected_return_date' => 'date',
        'actual_checkout_date' => 'date',
        'actual_return_date' => 'date',
    ];

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id', 'id');
    }

    public function crew()
    {
        return $this->belongsTo(User::class, 'crew_id', 'id');
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function getStatusLabelAttributes()
    {
        switch ($this->status) {
            case 'pending':
                return 'Menunggu Persetujuan';
            case 'approved':
                return 'Disetujui (Belum Diambil)';
            case 'rejected':
                return 'Ditolak';
            case 'borrowed':
                return 'Sedang Dipinjam';
            case 'returned':
                return 'Dikembalikan (Tepat Waktu)';
            case 'late_returned':
                return 'Dikembalikan Terlambat';
            case 'overdue':
                return 'Terlambat Belum Kembali';
            default:
                return '-';
        }
    }

    public function getStatusColorAtributes()
    {
        switch ($this->status) {
            case 'pending':
                return 'amber';
            case 'approved':
                return 'info';
            case 'rejected':
                return 'red';
            case 'borrowed':
                return 'blue';
            case 'returned':
                return 'green';
            case 'late_returned':
                return 'orange';
            case 'overdue':
                return 'red';
            default:
                return 'zinc';
        }
    }
}
