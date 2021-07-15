<?php

namespace App\Http\Controllers;

use App\Enquiries;
use App\Http\Requests\EnquiryRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SaveEnquiryController extends Controller
{
    public function store(EnquiryRequest $request)
    {
        DB::beginTransaction();

        try{

            Enquiries::create(
                [
                    'name' => $request->input("name"),
                    'service_id' => $request->input('service'),
                    'email' => $request->input("email"),
                    'phone_no' => $request->input("phone_no"),
                    'subject' => $request->input("subject"),
                    'message' => $request->input("message"),
                    'status' => 'Pending',
                ]
            );

            DB::commit();

            return redirect($request->header('referer'))->with(['status' => 'Updated Successfully, We Will Contact You Soon']);

        } catch( Exception $e) {
            Log::error('Enquiry Form Error ' . $e->getMessage() );
            DB::rollback();

            return response(['status' => 'Sorry Something Went Wrong'], 500);
        }
    }
}
