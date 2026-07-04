<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundedAccountSection;
use Illuminate\Http\Request;

class FundedAccountController extends Controller
{
    // Render Admin Form View
    public function edit()
    {
        $section = FundedAccountSection::first() ?? new FundedAccountSection();
        return view('admin.about.funded_account', compact('section'));
    }

    // Process Update Request
    public function update(Request $request)
    {
        $section = FundedAccountSection::firstOrNew([]);

        $section->fill([
            'main_heading'  => $request->main_heading,
            'left_title'    => $request->left_title,
            'divider_text'  => $request->divider_text,
            'right_title'   => $request->right_title,
            'btn1_text'     => $request->btn1_text,
            'btn1_url'      => $request->btn1_url,
            'btn1_subtext'  => $request->btn1_subtext,
            'btn2_text'     => $request->btn2_text,
            'btn2_url'      => $request->btn2_url,
            'btn2_subtext'  => $request->btn2_subtext,
            // Automatically filters empty or null lines submitted by admin
            'left_points'   => array_filter($request->left_points ?? []),
            'right_points'  => array_filter($request->right_points ?? []),
        ]);

        $section->save();

        return response()->json(['success' => true, 'message' => 'Split block configuration saved!']);
    }
}
