<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferito extends Model
{
    use HasFactory;

    protected $table = 'preferito';

    protected $fillable = [
        'id_user',
        'id_post'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo("App\Models\User", 'id_user');
    }

    public function post()
    {
        return $this->belongsTo("App\Models\Post", 'id_post');
    }
}
