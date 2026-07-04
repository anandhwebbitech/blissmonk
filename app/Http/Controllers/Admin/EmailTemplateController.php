<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailTemplate;
class EmailTemplateController extends Controller
{
    //
    public function index()
    {
        // First record-ah matum update/edit seivom
        $template = EmailTemplate::first();
        return view('admin.email_template.index', compact('template'));
    }

    // Form data-vai update seiya
    public function store(Request $request)
    {
        // Update or create based on ID directly without passing it in mass assignment
        $template = EmailTemplate::firstOrNew(['id' => 1]);

        $template->subject = $request->subject;
        $template->what_you_will_learn = $request->what_you_will_learn;
        $template->before_webinar = $request->before_webinar;
        $template->body_content = $request->body_content;
        $template->company_name = $request->company_name;
        $template->company_email = $request->company_email;
        $template->company_phone = $request->company_phone;
        
        $template->save(); // Id fillable-il illamaleye save aagi vidum

        return response()->json([
            'status' => true,
            'message' => 'Email template updated successfully!'
        ]);
    }
}
