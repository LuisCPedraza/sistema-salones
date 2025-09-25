<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomAvailability extends Model
{
    use HasFactory;

    protected $fillable = ['room_id','day_of_week','start_time','end_time'];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
