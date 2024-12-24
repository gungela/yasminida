<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produksi extends Model
{
    use HasFactory;
    protected $table = 'barangs';

    protected $fillable = [
        'customer_id',
        'user_id',
        'praproduct',
        'product',
        'harga',
        'jumlah',
        'total',
        'status',
        'keterangan',
        'tindakan',
        'date'
    ];
    
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
