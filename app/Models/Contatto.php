<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contatto extends Model
{
    use HasFactory;

    protected $table = 'contatto';

    protected $fillable = [
        'Nome',
        'email',
        'messaggio'
    ];

    public $timestamps = false;
}
