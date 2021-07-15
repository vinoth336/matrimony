<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MemberRegistrationRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $totalMembers = Member::count();
        $maleMembersCount = Member::where('gender', MALE)->count();
        $femaleMembersCount = Member::where('gender', FEMALE)->count();
        $memberRegisterationCount = MemberRegistrationRequest::count();

        return view('dashboard')
            ->with('totalMembers', $totalMembers)
            ->with('maleMembersCount', $maleMembersCount)
            ->with('femaleMembersCount', $femaleMembersCount)
            ->with('memberRegisterationCount', $memberRegisterationCount)
        ;
    }
}
