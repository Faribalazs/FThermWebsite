<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $workers = User::where('role', 'worker')->latest()->paginate(10);
        return view('admin.workers.index', compact('workers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $availablePermissions = User::getAvailablePermissions();
        return view('admin.workers.create', compact('availablePermissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['nullable', 'array'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'worker',
            'is_active' => true,
            'permissions' => $request->permissions ?? [],
        ]);

        return redirect()->route('admin.workers.index')->with('success', 'Worker created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $worker) // Laravel route model binding will try to find User by ID
    {
        // Ensure the user is actually a worker
        if ($worker->role !== 'worker') {
            abort(404);
        }
        
        $availablePermissions = User::getAvailablePermissions();
        return view('admin.workers.edit', compact('worker', 'availablePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $worker)
    {
        if ($worker->role !== 'worker') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,'.$worker->id],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            'permissions' => ['nullable', 'array'],
        ]);

        $worker->name = $request->name;
        $worker->email = $request->email;
        if ($request->filled('password')) {
            $worker->password = Hash::make($request->password);
        }
        $worker->permissions = $request->permissions ?? [];
        $worker->save();

        return redirect()->route('admin.workers.index')->with('success', 'Worker updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $worker)
    {
         if ($worker->role !== 'worker') {
            abort(404);
        }
        
        $worker->delete();
        return redirect()->route('admin.workers.index')->with('success', 'Worker deleted successfully.');
    }
    
    public function ban(User $worker)
    {
        if ($worker->role !== 'worker') {
            abort(404);
        }
        
        $worker->update(['is_active' => false]);
        return back()->with('success', 'Worker has been banned.');
    }
    
    public function unban(User $worker)
    {
        if ($worker->role !== 'worker') {
            abort(404);
        }
         
        $worker->update(['is_active' => true]);
        return back()->with('success', 'Worker has been activated.');
    }
}

