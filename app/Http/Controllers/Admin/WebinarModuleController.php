<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarModuleSection;
use Illuminate\Http\Request;

class WebinarModuleController extends Controller
{
    public function edit()
    {
        $section = WebinarModuleSection::first() ?? new WebinarModuleSection();
        return view('admin.about.modules', compact('section'));
    }

    public function store(Request $request)
    {
        $section = WebinarModuleSection::firstOrNew([]);
        $section->section_title = $request->section_title;

        // Image Processing
        if ($request->hasFile('editorial_image')) {
            $fileName = 'editorial_' . time() . '.' . $request->editorial_image->extension();
            $request->editorial_image->move(public_path('asset/img'), $fileName);
            $section->editorial_image = 'asset/img/' . $fileName;
        }

        // Processing Dynamic Modules
        $modules = [];
        if ($request->has('module_title')) {
            foreach ($request->module_title as $index => $title) {
                // வரிகளின் டைனமிக் அமைப்புகளையும் அதன் ஆக்சென்ட் ஸ்டைலையும் பிரிக்கிறது
                $items = [];
                if (isset($request->module_items[$index])) {
                    foreach ($request->module_items[$index] as $subIdx => $itemText) {
                        $items[] = [
                            'text' => $itemText,
                            'accent' => $request->module_accents[$index][$subIdx] ?? 'none' // none, green, red
                        ];
                    }
                }
                
                $modules[] = [
                    'title' => $title,
                    'items' => $items
                ];
            }
        }
        
        $section->modules_data = $modules;
        $section->save();

        return response()->json(['status' => true, 'message' => 'Webinar Matrix configuration synced successfully!']);
    }
}