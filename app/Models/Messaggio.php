<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Messaggio extends Model
{
    use HasFactory;

    protected $table = 'messaggio';

    protected $fillable = [
        'id_mittente',
        'id_destinatario',
        'messaggio'
    ];

    protected $dates = ['creato'];

    public $timestamps = false;

    public function mittente()
    {
        return $this->belongsTo("App\Models\User", 'id_mittente');
    }

    public function destinatario()
    {
        return $this->belongsTo("App\Models\User", 'id_destinatario');
    }
}
