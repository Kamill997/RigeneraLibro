<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immagine_User extends Model
{
    use HasFactory;

    protected $table = 'immagine_user';

    protected $fillable = [
        'id_user',
        'Nome',
        'path'
    ];

    public $timestamps = false;


    public function user()
    {
        return $this->belongsTo('App\Models\User', 'id_user');
    }
}
