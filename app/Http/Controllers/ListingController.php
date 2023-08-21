<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $listings = Listing::query()
            ->latest()
            ->filter(request(['tag', 'search']))
            ->paginate(6);
        return view('listings.index', compact('listings'));
    }

    public function show(Listing $listing): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('listings.show', compact('listing'));
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('listings.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => 'required|string',
            'company' => 'required|string|unique:listings,company',
            'location' => 'required|string',
            'website' => 'required|url',
            'email' => 'required|email',
            'tags' => 'required',
            'description' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('logos');
        }
        $data['user_id'] = auth()->id();

        Listing::query()->create($data);
        return redirect()->route('home')->with('message', 'Listing created successfully!');
    }

    public function edit(Listing $listing): View|\Illuminate\Foundation\Application|Factory|Application
    {
        if (auth()->id() != $listing->user_id) {
            abort(403);
        }
        return view('listings.edit', compact('listing'));
    }

    public function update(Request $request, Listing $listing): RedirectResponse
    {
        if (auth()->id() != $listing->user_id) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string',
            'company' => 'required|string',
            'location' => 'required|string',
            'website' => 'required|url',
            'email' => 'required|email',
            'tags' => 'required',
            'description' => 'required|string',
            'logo' => 'nullable|image',
        ]);

        if ($request->hasFile('logo')) {
            Storage::delete($listing->logo);
            $data['logo'] = $request->file('logo')->store('logos');
        }

        $listing->update($data);
        return back()->with(['message' => 'Listing updated successfully!']);
    }

    public function destroy(Listing $listing): RedirectResponse
    {
        if (auth()->id() != $listing->user_id) {
            abort(403);
        }
        $listing->delete();
        return back()->with(['message' => 'Listing deleted successfully!']);
    }

    public function manage(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $listings = auth()->user()->listings;
        return view('listings.manage', compact('listings'));
    }
}
