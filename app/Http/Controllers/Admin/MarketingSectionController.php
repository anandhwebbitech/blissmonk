<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingSection;
use Illuminate\Http\Request;

class MarketingSectionController extends Controller
{
    // Renders custom independent visual editor control deck
    public function edit()
    {
        $section = MarketingSection::first(); 
        if (!$section) {
            $section = new MarketingSection();
        }
        return view('admin.about.marketing_sections', compact('section'));
    }
    public function index()
    {
        $section = MarketingSection::first(); 
        if (!$section) {
            $section = new MarketingSection();
        }
        return view('admin.about.marketing_sections', compact('section'));
    }

    // Handles writing separate model schema parameters elements row tracking safely
    public function store(Request $request)
    {
        $section = MarketingSection::firstOrNew([]);

        // Module 1 Row Matrix Map
        $section->why_heading      = $request->why_heading;
        $section->why_subheading   = $request->why_subheading;
        $section->lead_text        = $request->lead_text;
        $section->problem_label    = $request->problem_label;
        $section->problems_list    = $request->problems_list; // Array parsed data mappings
        $section->result_title     = $request->result_title;
        $section->result_desc      = $request->result_desc;
        $section->truth_title      = $request->truth_title;
        $section->truth_desc       = $request->truth_desc;

        // Module 2 Row Matrix Map
        $section->program_headline = $request->program_headline;
        $section->program_subheadline = $request->program_subheadline;
        $section->discover_text    = $request->discover_text;
        $section->benefits_list    = $request->benefits_list; // Array parsed data mappings
        $section->pain_point_text  = $request->pain_point_text;
        $section->solution_text    = $request->solution_text;

        // Process Isolated Image File Uplinks safely 
        if ($request->hasFile('program_image')) {
            $fileName = 'prop_' . time() . '.' . $request->program_image->extension();
            $request->program_image->move(public_path('asset/img'), $fileName);
            $section->program_image = 'asset/img/' . $fileName;
        }

        $section->save();

        return response()->json(['status' => true, 'message' => 'Isolated records segments written successfully!']);
    }
}
