<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProblemSection;

class ProblemSectionController extends Controller
{
    public function index()
    {
        $problem = ProblemSection::firstOrNew([]);
        return view('admin.about.problem_section', compact('problem'));
    }

    public function store(Request $request)
    {
        // 1. Validate form fields from the new clean UI layout
        $request->validate([
            'heading'                    => 'required|string',
            'subheading_lead'            => 'required|string',
            'footer_text'                => 'required|string',
            'worst_part_title'           => 'required|string',
            'wondering_title'            => 'required|string',
            
            // CKEditor content blocks validation
            'challenges_rich_content'    => 'required|string',
            'worst_part_desc_content'    => 'required|string',
            'wondering_rich_content'     => 'required|string',
            
            'image'                      => 'nullable|image|mimes:webp,jpg,png,jpeg|max:2048'
        ]);

        $problem = ProblemSection::firstOrNew([]);
        
        // 2. Direct String Columns Mapping
        $problem->heading           = $request->heading;
        $problem->subheading_lead   = $request->subheading_lead;
        $problem->footer_text       = $request->footer_text;
        $problem->worst_part_title  = $request->worst_part_title;
        $problem->wondering_title   = $request->wondering_title;
        
        // 3. Mapping Rich-Text Blocks perfectly into your existing DB Schema
        // Good steps & bad loops HTML structure direct-ah single column-ah map aagum
        $problem->good_points       = $request->challenges_rich_content; 
        
        // Total worst part text description goes into desc_1
        $problem->worst_part_desc_1 = $request->worst_part_desc_content;
        
        // Target questions with bullets goes into wondering_footer
        $problem->wondering_footer  = $request->wondering_rich_content;

        // 4. Handling Old unused columns to avoid any SQL string/null validation issues
        $problem->bad_points        = null; 
        $problem->wondering_questions = null;
        $problem->mid_title         = '';
        $problem->worst_part_desc_2 = '';

        // 5. File Upload Handler
        if ($request->hasFile('image')) {
            if ($problem->image && file_exists(public_path($problem->image))) {
                @unlink(public_path($problem->image));
            }
            $file = $request->file('image');
            $fileName = 'problem_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/problem'), $fileName);
            $problem->image = 'uploads/problem/' . $fileName;
        }

        $problem->save();

        return response()->json([
            'status' => true, 
            'message' => 'Problem Section updated successfully!'
        ]);
    }
}