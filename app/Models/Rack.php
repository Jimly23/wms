<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rack extends Model
{
    protected $fillable = [
        'nama_rak',
        'barcode',
        'lokasi',
        'keterangan',
    ];

    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
