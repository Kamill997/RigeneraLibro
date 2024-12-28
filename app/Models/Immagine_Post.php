<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Immagine_Post extends Model
{
    use HasFactory;

    protected $table = 'immagine_post';

    protected $fillable = [
        'id_post',
        'path'
    ];

    public $timestamps = false;


    public function post()
    {
        return $this->belongsTo('App\Models\Post', 'id_post');
    }
}
