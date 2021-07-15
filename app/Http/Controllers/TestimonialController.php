<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTestimonialRequest;
use App\Models\Testimonial;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::OrderBy('created_at')->get();

        return view('testimonials.list', ['testimonials' => $testimonials]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTestimonialRequest $request)
    {

        DB::beginTransaction();
        try{

            $this->saveTestimonials(new Testimonial(), $request);

            DB::commit();

            return redirect()->route('testimonials.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data"], 500);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Testimonial $testimonial)
    {
        return view('testimonials.edit')->with(['testimonial' => $testimonial]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CreateTestimonialRequest $request, Testimonial $testimonial)
    {
        DB::beginTransaction();
        try{

            $this->saveTestimonials($testimonial, $request);

            DB::commit();

            return redirect()->route('testimonials.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Store Data"], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Testimonial $testimonial)
    {
        DB::beginTransaction();

        try{

            $testimonial->unlinkImage($testimonial->client_image);

            $testimonial->delete();

            DB::commit();

            return redirect()->route('testimonials.index')->with('status', 'Created Successfully');

        } catch(Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return response(['status' => "Can't Delete Data"], 500);
        }

    }


     /**
     * Create or Update the Testimonial in storage
     *
     * @param TestimonialsRequest $request
     * @param Testimonial $Testimonial
     * @return Testimonial
     */
    public function saveTestimonials(Testimonial $testimonial, $request)
    {
        $image = $request->has('client_image') ? $request->file('client_image') : null;

        $testimonial->storeImage($image, ['width' => 161, 'height' => 161]);
        $testimonial->client_name = $request->input('client_name');
        $testimonial->client_designation = $request->input('client_designation');
        $testimonial->comment = $request->input('comment');
        $testimonial->save();
        return $testimonial;
    }

}
