<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserBookingController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categoryId = $request->input('category_id');

        $query = Room::with('category');

        // Filter search
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('room_name', 'like', "%{$search}%")
                    ->orWhere('location', 'like', "%{$search}%");
            });
        }

        // Filter kategori
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $rooms = $query->paginate(12);
        $categories = Category::all();

        return view('bookings', compact('rooms', 'categories'));
    }

    public function store(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $request->validate([
            'id_rooms' => 'required|exists:rooms,id',
            'tgl_pinjam' => 'required|date|after_or_equal:today',
            'tgl_kembali_rencana' => 'required|date|after:tgl_pinjam',
        ]);

        // Cek apakah ruangan sudah dipesan di tanggal tersebut
        $exists = Booking::where('id_rooms', $request->id_rooms)
            ->whereNotIn('status', ['returned', 'cancelled'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('tgl_pinjam', [$request->tgl_pinjam, $request->tgl_kembali_rencana])
                    ->orWhereBetween('tgl_kembali_rencana', [$request->tgl_pinjam, $request->tgl_kembali_rencana])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('tgl_pinjam', '<=', $request->tgl_pinjam)
                            ->where('tgl_kembali_rencana', '>=', $request->tgl_kembali_rencana);
                    });
            })
            ->exists();

        if ($exists) {
            return back()
                ->with('error', 'Ruangan sudah dipesan di tanggal tersebut!')
                ->withInput();
        }

        Booking::create([
            'id_users' => Auth::id(),
            'id_rooms' => $request->id_rooms,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali_rencana' => $request->tgl_kembali_rencana,
            'status' => 'pending'
        ]);

        return redirect()->route('bookings')
            ->with('success', 'Peminjaman ruangan berhasil diajukan!');
    }

    public function show($id)
    {
        $booking = Booking::with('room')
            ->where('id_users', Auth::id())
            ->findOrFail($id);

        return view('bookings-show', compact('booking'));
    }

    public function history(Request $request)
{
    $userId = Auth::id();
    $perPage = $request->input('per_page', 5);
    $search = $request->input('search');

    $query = Booking::with('room.category')
        ->where('id_users', $userId);

    if ($search) {
        $query->whereHas('room', function($q) use ($search) {
            $q->where('room_name', 'like', "%{$search}%");
        });
    }

    $bookings = $query->orderBy('created_at', 'desc')->paginate($perPage);

    // Variabelnya bernama $stats (dengan 's' di belakang)
    $stats = [
        'pending'  => Booking::where('id_users', $userId)->where('status', 'pending')->count(),
        'approved' => Booking::where('id_users', $userId)->where('status', 'approved')->count(),
        'borrowed' => Booking::where('id_users', $userId)->where('status', 'borrowed')->count(),
        'returned' => Booking::where('id_users', $userId)->where('status', 'returned')->count(),
    ];

    // Pastikan di compact namanya 'stats' bukan 'status'
    return view('bookings-history', compact('bookings', 'stats'));
}

    public function cancel($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Silakan login terlebih dahulu!');
        }

        $booking = Booking::where('id_users', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);

        $booking->update([
            'status' => 'cancelled'
        ]);

        return back()->with('success', 'Peminjaman ruangan dibatalkan!');
    }
}
