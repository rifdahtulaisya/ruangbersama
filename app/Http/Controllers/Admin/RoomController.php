<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; 
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pagination - default 5 items per page
        $perPage = $request->input('per_page', 5);
        
        // Search functionality
        $search = $request->input('search');
        
        $rooms = Room::with('category')->when($search, function ($query, $search) {
            return $query->where('room_name', 'like', '%' . $search . '%');
        })->paginate($perPage);
        
        return view('admin.rooms.index', compact('rooms'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.rooms.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'room_name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
        ]);

        $data = $request->only('category_id', 'room_name', 'location');
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('rooms', 'public');
        }

        Room::create($data);

        return redirect()->route('admin.rooms.index')->with('success', 'Room created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::with('category')->findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        $categories = Category::all();
        return view('admin.rooms.edit', compact('room', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $request->validate([
        'category_id' => 'required|exists:categories,id',
        'room_name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
        'remove_image' => 'nullable|boolean'
    ]);

    $room = Room::findOrFail($id);
    
    $room->category_id = $request->category_id;
    $room->room_name = $request->room_name;
    $room->location = $request->location;
    
    // Handle image removal
    if ($request->remove_image == '1') {
        if ($room->image && Storage::exists('public/' . $room->image)) {
            Storage::delete('public/' . $room->image);
        }
        $room->image = null;
    }
    
    // Handle new image upload
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($room->image && Storage::exists('public/' . $room->image)) {
            Storage::delete('public/' . $room->image);
        }
        
        $imagePath = $request->file('image')->store('rooms', 'public');
        $room->image = $imagePath;
    }
    
    $room->save();
    
    return redirect()->route('admin.rooms.index')->with('success', 'Ruangan berhasil diupdate');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        $room->delete();

        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully.');
    }
}
