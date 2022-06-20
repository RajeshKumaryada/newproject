<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\OrderRecords;
use App\Models\Users;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderReportDayCtrl extends Controller
{

  /**
   * View for add order record
   */
  public function viewDayReport()
  {
    $users = Users::where('user_id', '!=', 1)->where('post', 4)->orderBy('username', 'asc')->get();

    $websites = WebsiteInfo::orderBy('site_name', 'asc')->get();

    return view('admin.order_management.order_day_report', ['users' => $users, 'websites' => $websites]);
  }


  /**
   * fecth Month Report
   */
  public function fecthDayReport(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "required|date",
        'user_id' => "nullable|numeric",
        'website_id' => "nullable|numeric",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $userId = $request->input('user_id');
    $websiteId = $request->input('website_id');

    $date = $this->firstLastDate($request->input('date'));
    $startDate = $date[0];
    $endDate = $date[1];



    $orders = OrderRecords::select(
      'order_date',
      DB::raw('sum(number_of_order) as total_order'),
      DB::raw("DATE_FORMAT(order_date,'%Y-%M-%d') as ord_date")
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('order_date')
      ->orderBy('order_date', 'asc');



    if (!empty($websiteId)) {
      $orders = $orders->where('website_id', $websiteId);
    }

    if (!empty($userId)) {
      $orders = $orders->where('user_id', $userId);
    }

    $orders = $orders->get();


    if ($orders->isEmpty()) {
      $return['code'] = 101;
      $return['msg'] = "No records found.";

      return response()->json($return);
    }




    /**
     * :::::::::::::::::::::::::::::::::::::
     * Below process is for day wise order
     * :::::::::::::::::::::::::::::::::::::
     */


    //Uncomment below code to get all date order details. not full months
    /*

    $ordArr = [];

    foreach ($orders as $row) {
      $ordArr[$row->order_date] = $row;
    }

    $orders = [];


    $dateArr = explode('-', $endDate);

    //create array for full month order
    for ($i = 1; $i <= $dateArr[2]; $i++) {

      //formatting loop date
      $crrDate = date('Y-m-d', strtotime("{$dateArr[0]}-{$dateArr[1]}-{$i}"));

      if (!empty($ordArr[$crrDate])) {
        $orders[] = [
          'ord_date' => $ordArr[$crrDate]->ord_date,
          'order_date' => $ordArr[$crrDate]->order_date,
          'total_order' => $ordArr[$crrDate]->total_order,
        ];
      } else {
        $orders[] = [
          'ord_date' => date('Y-F-d', strtotime($crrDate)),
          'order_date' => $crrDate,
          'total_order' => 0,
        ];
      }
    }
    //*/


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;

    return response()->json($return);
  }




  /**
   * fecth Month Report Details
   */
  public function fecthDayReportDetails(Request $request)
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


    $date = ($request->input('date'));


    $orders = OrderRecords::with(['username', 'websiteInfo'])
      ->whereDate('order_date', $date)
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
  public function fecthDayReportUsersDetails(Request $request)
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


    $date = $request->input('date');


    $orders = OrderRecords::with(['username'])->select(
      'user_id',
      DB::raw('sum(number_of_order) as total_order')
    )
      ->whereDate('order_date', $date)
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
  public function fecthDayReportUsersSiteDetails(Request $request)
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

    $date = $request->input('date');

    $userId = $request->input('userid');


    $orders = OrderRecords::with(['username', 'websiteInfo'])
      ->whereDate('order_date', $date)
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
  public function fecthDayReportSitesDetails(Request $request)
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


    $date = $request->input('date');


    $orders = OrderRecords::with(['websiteInfo'])->select(
      'website_id',
      DB::raw('sum(number_of_order) as total_order')
    )
      ->whereDate('order_date', $date)
      ->groupBy('website_id')
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
