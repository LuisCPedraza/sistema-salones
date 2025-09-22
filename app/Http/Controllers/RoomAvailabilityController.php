<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\RoomAvailability;
use Illuminate\Http\Request;

class RoomAvailabilityController extends Controller
{
    public function index(Room $room)
    {
        $availabilities = $room->availabilities;
        return view('rooms.availabilities.index', compact('room', 'availabilities'));
    }

    public function create(Room $room)
    {
        return view('rooms.availabilities.create', compact('room'));
    }

    public function store(Request $request, Room $room)
    {
        $data = $request->validate([
            'day_of_week' => 'required|integer|min:1|max:7',
            'start_time' => 'required|date_format:H:i',
            'end_time'   => 'required|date_format:H:i|after:start_time',
        ]);

        $room->availabilities()->create($data);

        return redirect()->route('rooms.availabilities.index', $room)
            ->with('success', 'Disponibilidad agregada correctamente.');
    }

    public function destroy(Room $room, RoomAvailability $availability)
    {
        $availability->delete();
        return redirect()->route('rooms.availabilities.index', $room)
            ->with('success', 'Disponibilidad eliminada correctamente.');
    }
}
