<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;
use App\Models\Blood;
use App\Models\Faqs;
use App\Models\SiteInformation;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        if(auth()->guard('member')->check()) {
            if(auth()->guard('member')->check()) {

                return redirect()->route('member.dashboard');
            }
        }

        $bloodList = Blood::orderBy('name')->get();
        $siteInformation = SiteInformation::first();
        $testmonials = Testimonial::orderBy('created_at', 'desc')->get();
        $faqs = Faqs::orderBy('sequence')->get();

        return view('public.index')
        ->with('bloodList', $bloodList)
        ->with('testmonials', $testmonials)
        ->with('faqs', $faqs)
        ;

    }
}
