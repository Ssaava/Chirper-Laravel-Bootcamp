<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
// test the index method by returning a resource
// use Illuminate\Http\Response;

// now test the Controller by returning a view
use Illuminate\View\View;

// add a new redirect response that will be used in the CRUD operations 
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;


class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(): Response
    // {
    //     return response("Hello world!");
    // }
    public function index(): View
    {
        // return view("chirps.index"); // this returns a view without constraints
        return view("chirps.index",[
            'chirps' => Chirp::with('user')->latest()->get()
        ]);
       

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'message'=>'required|string|max:255',
        ]);
        $request->user()->chirps()->create($validated);
        
        return redirect(route("chirps.index"));
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): View
    {
        // this authorizes the right user to update the chirp
        Gate::authorize('update',$chirp);
        return view("chirps.edit",[
            'chirp' => $chirp
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update',$chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);
        
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        Gate::authorize('delete',$chirp);
        $chirp->delete();
        return redirect(route('chirps.index'));
    }
}
