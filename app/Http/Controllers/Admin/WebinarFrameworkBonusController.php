<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebinarFrameworkBonus;
use Illuminate\Http\Request;

class WebinarFrameworkBonusController extends Controller
{
    public function edit()
    {
        $section = WebinarFrameworkBonus::first() ?? new WebinarFrameworkBonus();
        return view('admin.about.framework_bonuses', compact('section'));
    }

    public function store(Request $request)
    {
        $section = WebinarFrameworkBonus::firstOrNew([]);

        // Map basic inputs
        $section->fw_title = $request->fw_title;
        $section->fw_paragraph_1 = $request->fw_paragraph_1;
        $section->fw_emphasis_light = $request->fw_emphasis_light;
        $section->fw_emphasis_bold = $request->fw_emphasis_bold;
        $section->fw_paragraph_2 = $request->fw_paragraph_2;
        $section->fw_conclusion = $request->fw_conclusion;
        
        $section->perfect_title = $request->perfect_title;
        $section->not_perfect_title = $request->not_perfect_title;
        $section->bonus_heading = $request->bonus_heading;
        $section->urgent_text = $request->urgent_text;
        
        $section->risk_title = $request->risk_title;
        $section->expire_title = $request->expire_title;
        $section->expire_subtitle = $request->expire_subtitle;
        $section->footer_cta = $request->footer_cta;
        $section->footer_cta_highlight = $request->footer_cta_highlight;

        // Image Processing safely
        if ($request->hasFile('fw_image')) {
            $fileName = 'fw_' . time() . '.' . $request->fw_image->extension();
            $request->fw_image->move(public_path('asset/img'), $fileName);
            $section->fw_image = 'asset/img/' . $fileName;
        }

        // Filter and clean multi-input arrays
        $section->fw_list_items = array_filter($request->fw_list_items ?? []);
        $section->perfect_items = array_filter($request->perfect_items ?? []);
        $section->not_perfect_items = array_filter($request->not_perfect_items ?? []);
        $section->bonuses_cards = array_filter($request->bonuses_cards ?? []);
        $section->risk_paragraphs = array_filter($request->risk_paragraphs ?? []);
        $section->expire_items = array_filter($request->expire_items ?? []);

        $section->save();

        return response()->json(['status' => true, 'message' => 'Framework and Bonus sections synced successfully!']);
    }
}
