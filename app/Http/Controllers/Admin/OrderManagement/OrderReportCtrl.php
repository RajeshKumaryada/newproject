<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\OrderRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderReportCtrl extends Controller
{

  /**
   * View for add order record
   */
  public function viewMonthReport()
  {
    return view('admin.order_management.order_month_report');
  }


  /**
   * fecth Month Report
   */
  public function fecthMonthReport(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'start_date' => "required|date",
        'end_date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $start_date = $request->input('start_date');
    $end_date = $request->input('end_date');

    $startDate = "{$start_date}-01";

    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($end_date)), date('Y', strtotime($end_date)));
    $endDate = "{$end_date}-{$number_of_days}";


    $orders = OrderRecords::select(
      DB::raw('sum(number_of_order) as total_order'),
      DB::raw("DATE_FORMAT(order_date,'%Y-%M') as ord_month")
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('ord_month')
      ->orderBy('ord_month', 'desc')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }




  /**
   * fecth Month Report Details
   */
  public function fecthMonthReportDetails(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      // $return['msg'] = 'error';
      $return['msg'] = $validator->errors()->get('date');

      return response()->json($return);
    }


    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];


    $orders = OrderRecords::with(['username', 'websiteInfo'])
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->orderBy('order_date', 'desc')
      ->get();

    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }




  /**
   * fecth Month Report Users Details
   */
  public function fecthMonthReportUsersDetails(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      // $return['msg'] = 'error';
      $return['msg'] = $validator->errors()->get('date');

      return response()->json($return);
    }


    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];


    $orders = OrderRecords::with(['username'])->select(
      'user_id',
      DB::raw('sum(number_of_order) as total_order')
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('user_id')
      ->orderBy('total_order', 'desc')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }




  /**
   * fecth Month Report User's Site Details
   */
  public function fecthMonthReportUsersSiteDetails(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'userid' => "required|numeric",
        'date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      // $return['msg'] = 'error';
      $return['msg'] = implode(", ", $validator->errors()->all());

      return response()->json($return);
    }

    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];

    $userId = $request->input('userid');


    $orders = OrderRecords::with(['username', 'websiteInfo'])
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->where('user_id', $userId)
      ->orderBy('order_date', 'desc')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }



  /**
   * fecth Month Report Sites Details
   */
  public function fecthMonthReportSitesDetails(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      // $return['msg'] = 'error';
      $return['msg'] = $validator->errors()->get('date');

      return response()->json($return);
    }


    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];


    $orders = OrderRecords::with(['websiteInfo'])->select(
      'website_id',
      DB::raw('sum(number_of_order) as total_order')
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('website_id')
      ->orderBy('total_order', 'desc')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }




  /**
   * fecth Month Report Date Details
   */
  public function fecthMonthReportDateDetails(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      // $return['msg'] = 'error';
      $return['msg'] = $validator->errors()->get('date');

      return response()->json($return);
    }


    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];


    $orders = OrderRecords::select(
      'order_date',
      DB::raw('sum(number_of_order) as total_order')
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('order_date')
      ->orderBy('total_order', 'desc')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }


  /**
   * function for getting start date and end date of the month
   */
  private function firstLastDate($date)
  {
    $date = date("Y-m", strtotime($date));

    //start Date
    $ret[0] = "{$date}-01";

    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($ret[0])), date('Y', strtotime($ret[0])));

    //end Date
    $ret[1] =  "{$date}-{$number_of_days}";

    return $ret;
  }
}
