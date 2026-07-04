<?php

namespace App\Http\Controllers;

use App\Models\AboutSection;
use App\Models\Faq;
use App\Models\MarketingSection;
use App\Models\ProblemSection;
use App\Models\WebinarFrameworkBonus;
use App\Models\WebinarHero;
use App\Models\WebinarModuleSection;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\WebinarUserMail;
use App\Mail\WebinarAdminMail;

class FrontendController extends Controller
{
    //
        public function index(){
        $faqs = Faq::orderBy('sort_order', 'asc')->get();
        
            $faqColumns = $faqs->split(2); 
            
            $leftColumnFaqs = $faqColumns->get(0) ?? collect();
            $rightColumnFaqs = $faqColumns->get(1) ?? collect();

            $frameworkBonus = WebinarFrameworkBonus::first(); 
            $section = WebinarModuleSection::first();
            $marketing = MarketingSection::first();
            $problemsolving = ProblemSection::first();
            $about= AboutSection::first();
            $main_content = WebinarHero::first();
            // dd($main_content);

            return view('frontend.index', compact('leftColumnFaqs', 'rightColumnFaqs', 'frameworkBonus','section','marketing','problemsolving','about'));
        }

        public function webinarRegister(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'phone' => 'required|digits:10',
            'email' => 'required|email',
            'city'  => 'required|string|max:100',
        ]);

        $data = [
            'name'  => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'city'  => $request->city,
        ];

        try {

            // Send confirmation mail to user
            Mail::to($request->email)->send(new WebinarUserMail($data));

            // Send registration mail to admin
            Mail::to('anandhwebbitech@gmail.com')->send(new WebinarAdminMail($data));

            return back()->with('success', 'Registration completed successfully. Please check your email.');
        } catch (\Exception $e) {

            return back()->with('error', 'Unable to send email. ' . $e->getMessage());
        }
    }
}
