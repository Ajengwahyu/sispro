<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agama10 extends Model
{
    use HasFactory;

    public $table = 'agama10s';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama_agama'
    ];

    public function detail()
    {
        return $this->hasMany(DetailData10::class, 'id_agama', 'id');
    }
}
