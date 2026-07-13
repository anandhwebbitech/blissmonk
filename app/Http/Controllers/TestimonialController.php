<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use Yajra\DataTables\Facades\DataTables;
class TestimonialController extends Controller
{
    //
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Testimonial::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('is_active', function($row){
                    return $row->is_active 
                        ? '<span class="badge bg-success">Active</span>' 
                        : '<span class="badge bg-danger">Inactive</span>';
                })
                ->addColumn('video_preview', function($row){
                    // Embed link la irundhu video ID edukuradhukaana logic
                    $videoId = '';
                    if (preg_match('/embed\/([^"&?\/ ]{11})/', $row->video_url, $matches)) {
                        $videoId = $matches[1];
                    }
                    
                    // High Quality Thumbnail Link setup
                    $thumbnailUrl = $videoId ? "https://img.youtube.com/vi/{$videoId}/hqdefault.jpg" : "https://placeholder.co/120x68?text=No+Image";

                    // Clickable Preview HTML Block
                    return '
                        <div class="video-preview-container open-video-modal" data-embed="'.$row->video_url.'">
                            <img src="'.$thumbnailUrl.'" alt="Preview">
                            <div class="play-overlay">
                                <i class="fa-solid fa-play"></i>
                            </div>
                        </div>';
                })
                ->addColumn('action', function($row){
                    $editUrl = route('admin.testimonials.edit', $row->id);
                    $deleteRoute = route('admin.testimonials.destroy', $row->id);
                    
                    $btn = '<a href="'.$editUrl.'" class="btn btn-sm btn-outline-primary me-1"><i class="fa fa-edit"></i></a>';
                    $btn .= '<button data-route="'.$deleteRoute.'" class="btn btn-sm btn-outline-danger delete"><i class="fa fa-trash"></i></button>';
                    return $btn;
                })
                ->rawColumns(['is_active', 'video_preview', 'action'])
                ->make(true);
        }

        return view('admin.testimonials.index');
    }

    // 2. Create form-ah kaata
    public function create()
    {
        return view('admin.testimonials.create');
    }

    // 3. New Video Testimonial-ah save panna
    public function store(Request $request)
    {
        // Backend Validation Engine rules
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'is_active' => 'required|in:0,1',
        ]);

        $url = $request->video_url;
        $youtubeId = null;

        // Advanced Regex Matcher: Handles watch?v=, Shorts, embeds, and youtu.be shortlinks cleanly
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|shorts\/|watch\?v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        
        if (preg_match($pattern, $url, $matches)) {
            $youtubeId = $matches[1];
        }

        if (!$youtubeId) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'video_url' => ['Could not parse a valid YouTube Video ID from the link provided.']
                ]
            ], 422);
        }

        // Clean structural standard embed layout format string setup
        $embedUrl = "https://www.youtube.com/embed/" . $youtubeId;

        // Save Context execution
        Testimonial::create([
            'title' => $request->title,
            'video_url' => $embedUrl,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Video testimonial master entry successfully committed.'
        ], 200);
    }

    // 4. Edit form-ah kaata
    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    // 5. Data-va update panna
    public function update(Request $request, Testimonial $testimonial)
    {
        // Backend Validation Engine rules
        $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'is_active' => 'required|in:0,1',
        ]);

        $url = $request->video_url;
        $youtubeId = null;

        // Advanced Regex Matcher: Normal, Shorts, or Direct Embeds strings extract validation
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|shorts\/|watch\?v=)|youtu\.be\/)([^"&?\/ ]{11})/i';
        
        if (preg_match($pattern, $url, $matches)) {
            $youtubeId = $matches[1];
        }

        if (!$youtubeId) {
            return response()->json([
                'status' => false,
                'errors' => [
                    'video_url' => ['Could not parse a valid YouTube Video ID from the link provided.']
                ]
            ], 422);
        }

        // Dynamic standard layout transformation
        $embedUrl = "https://www.youtube.com/embed/" . $youtubeId;

        // Model Context Syncing
        $testimonial->update([
            'title' => $request->title,
            'video_url' => $embedUrl,
            'is_active' => $request->is_active,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Video testimonial master entry successfully synchronized.'
        ], 200);
    }

    // 6. Testimonial-ah delete panna
    public function destroy(Testimonial $testimonial)
    {
        try {
            // Record-ah database la irundhu delete panrom
            $testimonial->delete();

            // AJAX response script ku status true nu anuprom
            return response()->json([
                'status' => true,
                'message' => 'Testimonial entry has been permanently deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Enadhavadhu error vandha fallback mechanism
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete the testimonial context from server.'
            ], 500);
        }
    }
}
