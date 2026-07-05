<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoodsIn extends Model
{
    protected $table = 'goods_ins';

    protected $fillable = [
        'item_id',
        'tanggal',
        'qty',
        'keterangan',
        'created_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
