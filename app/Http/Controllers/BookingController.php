<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function getBookings()
    {
        $bookings = Booking::with(['user', 'room'])->get();
        return response()->json(['bookings' => $bookings]);
    }

    public function addBooking(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'room_id' => ['required', 'string','max:255'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'status' => ['required', 'string', 'in:pending,confirmed,cancelled,completed'],
        ]);


        $room = Room::findOrFail($request->room_id);

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'price' => $room->price,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Booking successfully created!',
            'booking' => $booking
        ]);
    }

    public function editBooking(Request $request, $id)
    {

        $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'room_id' => ['required', 'string', 'max:255'],
            'check_in' => ['required', 'date'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'status' => ['required', 'string', 'in:pending,confirmed,cancelled,completed'],

        ]);


        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found!'], 404);
        }


        if ($booking->room_id != $request->room_id) {
            $room = Room::findOrFail($request->room_id);
            $booking->price = $room->price;
        }

        $booking->update([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
        ]);

        return response()->json([
            'message' => 'Booking successfully updated!',
            'booking' => $booking
        ]);
    }

    public function deleteBooking($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found!'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking successfully deleted!']);
    }
}
