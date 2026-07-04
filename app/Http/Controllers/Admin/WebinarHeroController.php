<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarHero;
use Illuminate\Http\Request;


class WebinarHeroController extends Controller
{
    //
    public function index()
    {
        // Table-la irukura muthal row data-ai fetch pannuvom (Single-page control setup)
        $hero = WebinarHero::first();
        
        return view('admin.about.mainindex', compact('hero'));
    }

    /**
     * Store or Update the Webinar Hero details via AJAX.
     */
    public function store(Request $request)
    {
        // 1. Data Validation mapping layout matching image_ec1761.png
        $request->validate([
            'title'             => 'required|string|max:255',
            'subtitle'          => 'required|string|max:255',
            'description'       => 'required|string', // CKEditor markup structural string
            'btn_register_text' => 'required|string|max:255',
            'btn_register_url'  => 'nullable|url|max:255',
            'btn_whatsapp_text' => 'required|string|max:255',
            'btn_whatsapp_url'  => 'nullable|url|max:255',
        ]);

        // 2. Database update or create action logic
        // Row id always 1-ah target panni update aagum, data overwrite aagathu
        $hero = WebinarHero::updateOrCreate(
            ['id' => 1],
            [
                'title'             => $request->title,
                'subtitle'          => $request->subtitle,
                'description'       => $request->description,
                'btn_register_text' => $request->btn_register_text,
                'btn_register_url'  => $request->btn_register_url,
                'btn_whatsapp_text' => $request->btn_whatsapp_text,
                'btn_whatsapp_url'  => $request->btn_whatsapp_url,
            ]
        );

        // 3. Return JSON Response matching blade AJAX implementation
        return response()->json([
            'status'  => true,
            'message' => 'Webinar Hero Section details updated successfully!'
        ]);
    }
}
