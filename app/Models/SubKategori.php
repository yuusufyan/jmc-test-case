<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubKategori extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'kategori_id',
        'nama_sub_kategori',
        'batas_harga',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
