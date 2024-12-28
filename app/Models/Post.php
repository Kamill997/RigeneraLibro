<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';

    protected $fillable = [
        'id_corso',
        'id_user',
        'prezzo',
        'tipo',
        'titolo',
        'descrizione',
        'condizione',
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo("App\Models\User", 'id_user');
    }

    public function conversazione()
    {
        return $this->hasMany("App\Models\Conversazione", 'id_post', 'id');
    }

    public function immagine_post()
    {
        return $this->hasMany('App\Models\Immagine_Post', 'id_post');
    }

    public function corso()
    {
        return $this->belongsTo("App\Models\Corso", 'id_corso');
    }

    public function preferito()
    {
        return $this->hasMany("App\Models\Preferito", 'id_post');
    }
}
