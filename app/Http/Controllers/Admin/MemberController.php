<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;

class MemberController extends Controller
{
    /**
     * Display a listing of the members.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 5);
        $members = $query->orderBy('created_at', 'desc')->paginate($perPage);

        return view('admin.members.index', compact('members'));
    }

    /**
     * Export members to PDF with passwords.
     */
    public function exportPDF(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('created_at', 'desc')->get();

        foreach ($members as $member) {
            $member->plain_password = str_replace(' ', '', strtolower($member->username)) . '123';
        }

        $data = [
            'members' => $members,
            'title' => 'Laporan Data Anggota',
            'date' => date('d/m/Y H:i:s'),
            'total' => $members->count()
        ];

        $pdf = Pdf::loadView('admin.members.export-pdf', $data);
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan_anggota_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Export members to CSV with passwords.
     */
    public function export(Request $request)
    {
        $query = User::where('role', 'user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('number', 'like', "%{$search}%");
            });
        }

        $members = $query->orderBy('created_at', 'desc')->get();

        $filename = 'members_export_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($members) {
            $file = fopen('php://output', 'w');

            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, ['No', 'Username', 'Nama Lengkap', 'Nomor Anggota', 'Email', 'Password (Plain Text)', 'Tanggal Dibuat']);

            foreach ($members as $index => $member) {
                $plainPassword = str_replace(' ', '', strtolower($member->username)) . '123';

                fputcsv($file, [
                    $index + 1,
                    $member->username,
                    $member->name,
                    $member->number,
                    $member->email,
                    $plainPassword,
                    $member->created_at->format('d/m/Y H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('admin.members.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'number' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'sometimes|in:user,admin'
        ]);

        $generatedPassword = str_replace(' ', '', strtolower($validated['username'])) . '123';

        $validated['password'] = Hash::make($generatedPassword);
        $validated['role'] = $validated['role'] ?? 'user';

        User::create($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Berhasil ditambahkan.');
    }

    /**
     * Display the specified member.
     */
    public function show(User $member)
    {
        if ($member->role !== 'user') {
            abort(404);
        }

        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(User $member)
    {
        if ($member->role !== 'user') {
            abort(404);
        }

        return view('admin.members.edit', compact('member'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, User $member)
    {
        if ($member->role !== 'user') {
            abort(404);
        }

        $validated = $request->validate([
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($member->id)],
            'name' => 'required|string|max:255',
            'number' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($member->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($member->id)],
            'role' => 'sometimes|in:user,admin'
        ]);

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'required|string|min:8'
            ]);
            $validated['password'] = Hash::make($request->password);
        }

        $validated['role'] = $validated['role'] ?? $member->role;

        $member->update($validated);

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil diupdate.');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(User $member)
    {
        if ($member->role !== 'user') {
            abort(404);
        }

        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Member berhasil dihapus.');
    }
}
