<?php

namespace App\Http\Controllers;

use App\Models\Faqs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FaqsController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $faqs = Faqs::OrderBy('sequence')->get();

        return view('faqs.list', ['faqs' => $faqs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $faq = new Faqs();
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->sequence = Faqs::get()->count();
        $faq->save();

        return redirect()->route('faqs.index')->with('status', 'Created Successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function show(Faqs $faqs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function edit(Faqs $faq)
    {
        return view('faqs.edit')->with(['faq' => $faq]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faqs $faq)
    {
        $faq->question = $request->input('question');
        $faq->answer = $request->input('answer');
        $faq->sequence = Faqs::get()->count();
        $faq->save();

        return redirect()->route('faqs.index')->with('status', 'Created Successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faqs $faq)
    {
        $faq->delete();

        return redirect()->route('faqs.index')->with('status', 'Removed Successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faqs  $faqs
     * @return \Illuminate\Http\Response
     */
    public function updateSequence(Request $request)
    {

        DB::beginTransaction();

        try
        {
            foreach($request->input('sequence') as $sequence => $id) {
                $faq = Faqs::find($id);
                $faq->sequence = $sequence + 1;
                $faq->save();
            }
        } catch(Exception $e) {
            DB::rollback();
            response('Cannot Update Sequence', 500);
        }

        DB::commit();

        return response(['message' => 'Updated Successfully'], 200);
    }
}
