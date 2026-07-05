<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'rack_id',
        'kode_barang',
        'nama_barang',
        'stok',
        'satuan',
        'keterangan',
    ];

    public function rack()
    {
        return $this->belongsTo(Rack::class);
    }

    public function goodsIns()
    {
        return $this->hasMany(GoodsIn::class);
    }

    public function goodsOuts()
    {
        return $this->hasMany(GoodsOut::class);
    }
}
