<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $validated = $request->validated();

        $image_path = $file_path = null;
        if ($request->hasFile('image')) {
            $image_path = $request->file('image')->store('images', 'public');
            $validated['image'] = $image_path;
        }
        if ($request->hasFile('file')) {
            $file_path = $request->file('file')->store('files', 'public');
            $validated['file'] = $file_path;
        }
        User::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
        ], 200);
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        $validated = $request->validated();
        $image_path = $file_path = null;
        if ($request->hasFile('image')) {
            unlink(storage_path('app/public/' . $user->image));
            $image_path = $request->file('image')->store('images', 'public');
            $validated['image'] = $image_path;
        }
        if ($request->hasFile('file')) {
            unlink(storage_path('app/public/' . $user->file));
            $file_path = $request->file('file')->store('files', 'public');
            $validated['file'] = $file_path;
        }
        $user->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ], 200);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        $user = User::findOrFail($id);
        unlink(storage_path('app/public/' . $user->image));
        unlink(storage_path('app/public/' . $user->file));
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ], 200);
    }

    public function list(Request $request)
    {
        $query = User::query();
        if ($request->has('search')) {
            $search = strtolower($request->search);
            $query->whereLike('email', $search);
            $query->orWhereLike('name', $search);
            $query->orWhereLike('gender', $search);
        }
        $users = $query->paginate();
        return view('users.list', compact('users'));
    }
}