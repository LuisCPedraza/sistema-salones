<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = []; // Permitir asignación masiva

    /**
     * Un profesor pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
