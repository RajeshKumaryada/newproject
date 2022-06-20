<?php

namespace App\Http\Controllers\LocationTrace;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LocationTraceCtrl extends Controller
{

  /**
   * Update lat lon location
   */
  public function updateLocation(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'lat' => "required",
        'lon' => "required",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $latitude = $request->input('lat');
    $longitude = $request->input('lon');

    $data = [
      'latitude' => $latitude,
      'longitude' => $longitude,
    ];

    $request->session()->put('location_trace', serialize($data));

    $return['code'] = 200;
    $return['msg'] = 'Location Set Successfully.';

    return response()->json($return);
  }
}
