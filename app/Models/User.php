<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $table = 'user';

    protected $fillable = [
        'name',
        'lastName',
        'username',
        'email',
        'password',
        'id_facolta'
    ];
    public $timestamps = false;
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function immagine_user()
    {
        return $this->hasOne('App\Models\Immagine_User', 'id_user');
    }

    public function facolta()
    {
        return $this->belongsTo("App\Models\Facolta", "id_facolta");
    }

    public function post()
    {
        return $this->hasMany("App\Models\Post", "id_user");
    }

    public function preferito()
    {
        return $this->hasMany("App\Models\Preferito", 'id_user');
    }

    public function messaggio()
    {
        return $this->hasMany("App\Models\Messaggio", 'id_mittente');
    }
}
