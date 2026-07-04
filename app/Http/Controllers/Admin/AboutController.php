<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutSection; // உங்கள் Model-ன் பெயர்
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Display the About section management page.
     */
    public function index(Request $request)
    {
        $about = AboutSection::first();

        return view('admin.about.index', compact('about'));
    }

    /**
     * Update or Create the single row for About section.
     */
    public function update(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Max 2MB
        ]);

        date_default_timezone_set('Asia/Kolkata');

        $about = AboutSection::firstOrNew([]);
        $about->title = $request->title;
        $about->description = $request->description;

        if ($request->hasFile('image')) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }

            $file = $request->file('image');
            $fileName = 'about_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            
            $file->move(public_path('uploads/about'), $fileName);
            
            $about->image = 'uploads/about/' . $fileName;
        }

        $about->save();

        return redirect()->back()->with('success', 'About section settings updated successfully!');
    }
    public function store(Request $request)
    {
        // 1. Validation-il 'expertise_description'-ai add seiyavum
        $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'expertise_title'       => 'required|string|max:255',
            'expertise_subtitle'    => 'required|string|max:255',
            'expertise_description' => 'required|string', // <-- Intha line puthusu
            'expertise_items'       => 'required|array|min:1',
            'expertise_items.*'     => 'required|string|max:255',
        ]);

        date_default_timezone_set('Asia/Kolkata');

        $about = AboutSection::firstOrNew([]);
        
        $about->title = $request->title;
        $about->description = $request->description;
        $about->expertise_title = $request->expertise_title;
        $about->expertise_subtitle = $request->expertise_subtitle;
        $about->expertise_description = $request->expertise_description; // <-- DB-il save aagiradhu
        $about->expertise_items = $request->expertise_items; 

        // Image Upload Handling
        if ($request->hasFile('image')) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }
            $file = $request->file('image');
            $fileName = 'about_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/about'), $fileName);
            $about->image = 'uploads/about/' . $fileName;
        }

        $about->save();

        return response()->json([
            'status' => true,
            'message' => 'Who We Are & Expertise Section updated successfully!'
        ]);
    }
}