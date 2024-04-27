<?php

namespace App\Http\Controllers;

use App\Http\Requests\CityStateRequest;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function getCities(CityStateRequest $request) {

        return response()->json(getCitiesBasedState($request->state));
    }
}
