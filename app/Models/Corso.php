<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Corso extends Model
{
    use HasFactory;

    protected $table = 'corso';

    protected $fillable = [
        'Nome'
    ];

    public $timestamps = false;

    public function corso()
    {
        return $this->hasMany("App\Models\Post", 'id_corso');
    }

    public function facolta()
    {
        return $this->belongsTo("App\Models\Facolta", "id_facolta");
    }
}
