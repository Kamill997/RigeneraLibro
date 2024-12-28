<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facolta extends Model
{
    use HasFactory;

    protected $table = 'facolta';

    protected $fillable = [
        'Nome'
    ];

    public $timestamps = false;

    public function corso()
    {
        return $this->hasMany("App\Models\Corso", 'id_facolta');
    }
}
