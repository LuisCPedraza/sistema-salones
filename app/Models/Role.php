<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Esta línea es importante para permitir la creación masiva
    protected $guarded = [];

    // Un rol puede tener muchos usuarios
    public function users()
    {
        return $this->hasMany(User::class);
    }
}