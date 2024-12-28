<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immagine_Sito extends Model
{
    protected $table = 'immagine_sito';

    public $timestamps = false;

    protected $fillable = [
        'Nome',
        'path'
    ];
}
