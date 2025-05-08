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

        'number' => ['required', 'string', 'max:255'],
        'price' => ['required', 'string', 'max:255'],
        'name' => ['required', 'string', 'max:255'],
        'type' => ['required', 'string', 'max:255'],
        'status' => ['required', 'string', 'max:255'],
        'capacity' => ['required', 'integer'],
        'location' => ['required', 'string', 'max:255'],
        'description' => ['nullable', 'string'],
        
        ]);

        $room = Room::create([
            'number' => $request->number,
            'price' => $request->price,
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'capacity' => $request->capacity,
            'location' => $request->location,
            'description' => $request->description,
        ]);

        return response()->json(['message' => 'Room successfully created!', 'room' => $room]);

    }
    public function editRoom(Request $request, $id){
        $request->validate([
            'number' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $room = Room::find($id);

        if(!$room){
            return response()->json(['message' => 'Room not found!'], 404);
        }

        $room->update([
            'number' => $request->number,
            'price' => $request->price,
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
            'capacity' => $request->capacity,
            'location' => $request->location,
            'description' => $request->description,
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
