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
    private function parseYoutubeUrl($url)
    {
        if (empty($url)) return null;

        $videoId = '';
        // Standard and Mobile/Short links regex mapping
        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url,$match)) {
            $videoId =$match[1];
        }

        return $videoId ? "https://www.youtube.com/embed/" . $videoId : null;
    }
    public function update(Request $request)
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', 
            'video_url'             => 'nullable|url|max:255', 
            'expertise_title'       => 'required|string|max:255',
            'expertise_subtitle'    => 'required|string|max:255',
            'expertise_description' => 'required|string',
            'expertise_items'       => 'required|array|min:1',
            'expertise_items.*'     => 'required|string|max:255',
        ]);

        date_default_timezone_set('Asia/Kolkata');

        $about = AboutSection::firstOrNew([]);
        $about->title = $request->title;
        $about->description = $request->description;
        
        // Convert regular YouTube link to dynamic Embed link format
        $about->video_url = $this->parseYoutubeUrl($request->video_url); 
        
        $about->expertise_title = $request->expertise_title;
        $about->expertise_subtitle = $request->expertise_subtitle;
        $about->expertise_description = $request->expertise_description;
        $about->expertise_items = $request->expertise_items; 

        // Image Action Logic (Remove Request from AJAX)
        if ($request->input('remove_image') == 1) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }
            $about->image = null;
        }

        // Video Action Logic (Remove Request from AJAX)
        if ($request->input('remove_video') == 1) {
            $about->video_url = null;
        }

        if ($request->hasFile('image') && $request->input('remove_image') != 1) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }
            $file = $request->file('image');
            $fileName = 'about_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/about'), $fileName);
            $about->image = 'uploads/about/' . $fileName;
        }

        $about->save();

        if ($request->ajax()) {
            return response()->json([
                'status' => true,
                'message' => 'About section settings updated successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'About section settings updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'                 => 'required|string|max:255',
            'description'           => 'required|string',
            'image'                 => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url'             => 'nullable|url|max:255', 
            'expertise_title'       => 'required|string|max:255',
            'expertise_subtitle'    => 'required|string|max:255',
            'expertise_description' => 'required|string', 
            'expertise_items'       => 'required|array|min:1',
            'expertise_items.*'     => 'required|string|max:255',
        ]);

        date_default_timezone_set('Asia/Kolkata');

        $about = AboutSection::firstOrNew([]);
        
        $about->title = $request->title;
        $about->description = $request->description;
        
        // Convert regular YouTube link to dynamic Embed link format
        $about->video_url = $this->parseYoutubeUrl($request->video_url); 
        
        $about->expertise_title = $request->expertise_title;
        $about->expertise_subtitle = $request->expertise_subtitle;
        $about->expertise_description = $request->expertise_description; 
        $about->expertise_items = $request->expertise_items; 

        // Handle AJAX clear commands
        if ($request->input('remove_image') == 1) {
            if ($about->image && file_exists(public_path($about->image))) {
                @unlink(public_path($about->image));
            }
            $about->image = null;
        }

        if ($request->input('remove_video') == 1) {
            $about->video_url = null;
        }

        if ($request->hasFile('image') && $request->input('remove_image') != 1) {
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