<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';

    protected $fillable = [
        'name',
        'email',
        'nohandphone',
        'alamat',
        'status',
    ];


    public function barangs()
    {
        return $this->hasMany(Produksi::class);
    }
}
