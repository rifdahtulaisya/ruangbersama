<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);

        $query = Booking::with(['user', 'room']);

        // Filter search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%");
                })->orWhereHas('room', function ($roomQuery) use ($search) {
                    $roomQuery->where('room_name', 'like', "%{$search}%");
                });
            });
        }

        $bookings = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.create', compact('users', 'rooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id',
            'id_rooms' => 'required|exists:rooms,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:pending,approved,borrowed,returned,cancelled'
        ]);

        Booking::create($request->all());

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['user', 'room'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);
        $users = User::all();
        $rooms = Room::all();
        return view('admin.bookings.edit', compact('booking', 'users', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_users' => 'required|exists:users,id',
            'id_rooms' => 'required|exists:rooms,id',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'tgl_kembali_realisasi' => 'nullable|date|after_or_equal:tgl_pinjam',
            'status' => 'required|in:pending,approved,borrowed,returned,cancelled',
            'teguran' => 'nullable|string'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update($request->all());

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking berhasil dihapus');
    }

    /**
     * Additional method: Confirm/Approve booking
     */
    public function approve(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'approved']);

        return redirect()->back()
            ->with('success', 'Booking berhasil disetujui');
    }

    /**
     * Additional method: Mark as borrowed
     */
    public function borrow(string $id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update([
            'status' => 'borrowed',
            'tgl_pinjam' => now()->toDateString()
        ]);

        return redirect()->back()
            ->with('success', 'Barang sudah dipinjam');
    }

    /**
     * Additional method: Return item
     */
    public function returnItem(string $id)
    {
        $booking = Booking::findOrFail($id);

        $telat = false;
        if ($booking->tgl_kembali_rencana < now()->toDateString()) {
            $telat = true;
        }

        $booking->update([
            'status' => 'returned',
            'tgl_kembali_realisasi' => now()->toDateString(),
            'teguran' => $telat ? 'Terlambat mengembalikan barang' : null
        ]);

        return redirect()->back()
            ->with('success', $telat ? 'Barang dikembalikan (TERLAMBAT)' : 'Barang dikembalikan');
    }
}
