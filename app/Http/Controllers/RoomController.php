<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{

    public function getRooms(){
        $rooms = Room::with('')->get();

        return response()->json(['rooms' => $rooms]);

    }

    public function addRoom(Request $request){
        $request->validate([
            'room_number' => ['required', 'string', 'max:255'],
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:255'],
            'room_status' => ['required', 'string', 'max:255'],
            'room_capacity' => ['required', 'integer'],
            'room_location' => ['required', 'string', 'max:255'],
            'room_description' => ['nullable', 'string'],
        ]);

        $room = Room::create([
            'room_number' => $request->room_number,
            'room_name' => $request->room_name,
            'room_type' => $request->room_type,
            'room_status' => $request->room_status,
            'room_capacity' => $request->room_capacity,
            'room_location' => $request->room_location,
            'room_description' => $request->room_description,
        ]);

        return response()->json(['message' => 'Room successfully created!', 'room' => $room]);

    }
    public function editRoom(Request $request, $id){
        $request->validate([
            'room_number' => ['required', 'string', 'max:255'],
            'room_name' => ['required', 'string', 'max:255'],
            'room_type' => ['required', 'string', 'max:255'],
            'room_status' => ['required', 'string', 'max:255'],
            'room_capacity' => ['required', 'integer'],
            'room_location' => ['required', 'string', 'max:255'],
            'room_description' => ['nullable', 'string'],
        ]);

        $room = Room::find($id);

        if(!$room){
            return response()->json(['message' => 'Room not found!'], 404);
        }

        $room->update([
            'room_number' => $request->room_number,
            'room_name' => $request->room_name,
            'room_type' => $request->room_type,
            'room_status' => $request->room_status,
            'room_capacity' => $request->room_capacity,
            'room_location' => $request->room_location,
            'room_description' => $request->room_description,
        ]);

        return response()->json(['message' => 'Room successfully updated!', 'room' => $room]);

    }
    public function deleteRoom($id){
        $room = Room::find($id);

        if(!$room){
            return response()->json(['message' => 'Room not found!'], 404);
        }

        $room->delete();

        return response()->json(['message' => 'Room successfully deleted!']);

    }


}
