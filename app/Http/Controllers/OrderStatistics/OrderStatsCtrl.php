<?php

namespace App\Http\Controllers\OrderStatistics;

use App\Classes\OrderPerformance\PerformanceBySeo;
use App\Classes\Variables\WorkTeamType;
use App\Http\Controllers\Controller;
use App\Models\OrderRecords;
use App\Models\Users;
use App\Models\WebsiteInfo;
use App\Models\WorkTeamInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderStatsCtrl extends Controller
{




  /**
   * Get Year sales data
   */
  public function fetchYearSales(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'sales_year' => "nullable|numeric|min:1900|max:2099",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_year');

      return response()->json($return);
    }

    $sales_year = $request->input('sales_year');


    if (!empty($sales_year)) {
      $date = $sales_year;

      if (strtotime($sales_year) > strtotime(date('Y'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested year is future year.";

        return response()->json($return);
      }
    } else {
      //getting current year
      $date = date('Y');
    }

    //start date
    $startDate = "{$date}-01-01";



    //calculating end date

    //if submitted year is != current year
    if ($date != date('Y')) {
      $endDate = "{$date}-12-31";
    } else {

      //if submitted year is empty or curent year
      //calculating current month
      $endDate = date("Y-m");

      $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($endDate)), date('Y', strtotime($endDate)));
      $endDate = date("Y-m") . "-" . $number_of_days;
    }




    $orders = OrderRecords::select(
      DB::raw('sum(number_of_order) as total_order'),
      DB::raw("DATE_FORMAT(order_date,'%Y-%m') as ord_month")
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('ord_month')
      ->orderBy('ord_month', 'asc')
      ->get();


    $ordArr = [];

    //making order month as key
    foreach ($orders as $row) {
      $ordArr[$row->ord_month] = $row;
    }



    $orders = [];

    //getting end date month
    $endMonth = date('m', strtotime($endDate));


    //create array for full year
    for ($i = 1; $i <= $endMonth; $i++) {

      //formatting loop date
      $crrMonth = date('Y-m', strtotime("{$date}-{$i}"));

      if (!empty($ordArr[$crrMonth])) {
        $orders[] = [
          'ord_date' => $ordArr[$crrMonth]->ord_month,
          'month' => strtoupper(date('M', strtotime($crrMonth))),
          'orders' => $ordArr[$crrMonth]->total_order,
        ];
      } else {
        $orders[] = [
          'ord_date' => $crrMonth,
          'month' => strtoupper(date('M', strtotime($crrMonth))),
          'orders' => 0,
        ];
      }
    }


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['year'] = $date;

    return response()->json($return);
  }



  /**
   * Get Year sales data
   */
  public function 
  fetchMonthSales(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'sales_month' => "nullable|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_month');

      return response()->json($return);
    }

    $sales_month = $request->input('sales_month');


    if (!empty($sales_month)) {
      $date = $sales_month;

      if (strtotime($sales_month) > strtotime(date('Y-m'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested month is future date.";

        return response()->json($return);
      }
    } else {
      //getting current year
      $date = date('Y-m');
    }

    //start date
    $startDate = "{$date}-01";


    //calculating end date

    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
    $endDate = $date . "-" . $number_of_days;

    $orders = OrderRecords::select(
      'order_date',
      DB::raw('sum(number_of_order) as total_order'),
      // DB::raw("DATE_FORMAT(order_date,'%Y-%M-%d') as ord_date")
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('order_date')
      ->orderBy('order_date', 'asc')
      ->get();


    $ordArr = [];

    //making order month as key
    foreach ($orders as $row) {
      $ordArr[$row->order_date] = $row;
    }



    /**
     * :::::::::::::::::::::::::::::::::::::
     * Below process is for day wise order
     * :::::::::::::::::::::::::::::::::::::
     */

    $orders = [];

    $dateArr = explode('-', $endDate);

    //create array for full month order
    for ($i = 1; $i <= $dateArr[2]; $i++) {

      //formatting loop date
      $crrDate = date('Y-m-d', strtotime("{$dateArr[0]}-{$dateArr[1]}-{$i}"));

      if (!empty($ordArr[$crrDate])) {
        $orders[] = [
          'date' => date('d M', strtotime($crrDate)),
          // 'order_date' => $ordArr[$crrDate]->order_date,
          'orders' => $ordArr[$crrDate]->total_order,
        ];
      } else {
        $orders[] = [
          'date' => date('d M', strtotime($crrDate)),
          // 'order_date' => $crrDate,
          'orders' => 0,
        ];
      }
    }


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['year'] = date('F Y', strtotime($date));

    return response()->json($return);
  }



  /**
   * Get month sales by the user
   */
  public function fetchMonthSalesUser(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'sales_month' => "nullable|date",
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_month');

      return response()->json($return);
    }

    $sales_month = $request->input('sales_month');


    $isCurrentMonth = false;
    $workingDays = 0;


    if (!empty($sales_month)) {
      $date = $sales_month;

      if (strtotime($sales_month) > strtotime(date('Y-m'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested month is future date.";

        return response()->json($return);
      }


      //check current month
      if ($date == date('Y-m')) {
        $isCurrentMonth = true;
        $workingDays = ((int)date('j') - 1);
      }
    } else {
      //getting current year and month
      $date = date('Y-m');


      $isCurrentMonth = true;
      $workingDays = ((int)date('j') - 1);
    }



    //start date
    $startDate = "{$date}-01";


    //calculating end date
    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
    $endDate = $date . "-" . $number_of_days;


    //getting users list of all SEOs
    $users = Users::select('user_id', 'username')
      ->where('status', 1)
      ->where(function ($sql) {
        return $sql->where('post', 4);
      })
      ->orderBy('username', 'ASC')
      ->get();


    $orders = [];

    //creating object for month average
    $monthAvg = new PerformanceBySeo();

    $count = 0;

    foreach ($users as $row) {

      $order = OrderRecords::select(
        'user_id',
        DB::raw('sum(number_of_order) as total_order')
      )
        ->whereDate('order_date', '>=', $startDate)
        ->whereDate('order_date', '<=', $endDate)
        ->where('user_id', $row->user_id)
        ->groupBy('user_id')
        ->orderBy('total_order', 'desc')
        ->first();





      if (!empty($order)) {

        $orders[$count] = [
          'user_id' => $row->user_id,
          'username' => $row->username,
          'orders' => $order->total_order
        ];
      } else {
        $orders[$count] = [
          'user_id' => $row->user_id,
          'username' => $row->username,
          'orders' => 0
        ];
      }



      /**
       * Find order Zone
       */
      if ($isCurrentMonth) {
        $tempAvgArr = $monthAvg->monthAvg($orders[$count]['orders'], $monthAvg->getTagetOrdersAvg($workingDays, $number_of_days));

        $orders[$count] = array_merge($orders[$count], $tempAvgArr);
      } else {
        $tempAvgArr = $monthAvg->month($orders[$count]['orders']);

        $orders[$count] = array_merge($orders[$count], $tempAvgArr);
      }


      $count++;
    }



    //array short by top orders
    array_multisort(array_column($orders, 'orders'), SORT_DESC, $orders);



    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['month'] = date('F Y', strtotime($date));

    return response()->json($return);
  }




  /**
   * Get Year sales by the user
   */
  public function fetchYearSalesUser(Request $request)
  {


    $validator = Validator::make(
      $request->all(),
      [
        'sales_year' => "nullable|numeric|min:1900|max:2099",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_year');

      return response()->json($return);
    }

    $sales_year = $request->input('sales_year');


    if (!empty($sales_year)) {
      $date = $sales_year;

      if (strtotime($sales_year) > strtotime(date('Y'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested year is future year.";

        return response()->json($return);
      }
    } else {
      //getting current year
      $date = date('Y');
    }

    //start date
    $startDate = "{$date}-01-01";



    //calculating end date

    //if submitted year is != current year
    if ($date != date('Y')) {
      $endDate = "{$date}-12-31";
    } else {

      //if submitted year is empty or curent year
      //calculating current month
      $endDate = date("Y-m");

      $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($endDate)), date('Y', strtotime($endDate)));
      $endDate = date("Y-m") . "-" . $number_of_days;
    }


    //getting users list of all SEOs
    $users = Users::select('user_id', 'username')
      ->where('status', 1)
      ->where(function ($sql) {
        return $sql->where('post', 4);
      })
      ->orderBy('username', 'ASC')
      ->get();


    $orders = [];

    foreach ($users as $row) {

      $order = OrderRecords::select(
        'user_id',
        DB::raw('sum(number_of_order) as total_order')
      )
        ->whereDate('order_date', '>=', $startDate)
        ->whereDate('order_date', '<=', $endDate)
        ->where('user_id', $row->user_id)
        ->groupBy('user_id')
        ->orderBy('total_order', 'desc')
        ->first();


      if (!empty($order)) {

        $orders[] = [
          'user_id' => $row->user_id,
          'username' => $row->username,
          'orders' => $order->total_order
        ];
      } else {
        $orders[] = [
          'user_id' => $row->user_id,
          'username' => $row->username,
          'orders' => 0
        ];
      }
    }

    array_multisort(array_column($orders, 'orders'), SORT_DESC, $orders);


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['year'] = $date;

    return response()->json($return);
  }



  /**
   * Get cruuent month tatal sales data
   */
  public function fetchCrrMonthTotalSale()
  {
    //getting current year and month
    $date = date('Y-m');
    // $date = "2021-04";

    $startDate = "{$date}-01";

    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
    $endDate = "{$date}-{$number_of_days}";

    $orders = OrderRecords::select(
      DB::raw('sum(number_of_order) as total_order'),
      DB::raw("DATE_FORMAT(order_date,'%Y-%m') as ord_month")
    )
      ->whereDate('order_date', '>=', $startDate)
      ->whereDate('order_date', '<=', $endDate)
      ->groupBy('ord_month')
      ->get();


    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['year'] = $date;

    return response()->json($return);
  }



  /**
   * fetch Month Order By Sales Team
   */
  public function fetchMonthOrderBySalesTeam(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'sales_month' => "nullable|date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_month');

      return response()->json($return);
    }

    $sales_month = $request->input('sales_month');


    if (!empty($sales_month)) {
      $date = $sales_month;

      if (strtotime($sales_month) > strtotime(date('Y-m'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested month is future date.";

        return response()->json($return);
      }
    } else {
      //getting current year
      $date = date('Y-m');
    }

    //start date
    $startDate = "{$date}-01";


    //calculating end date

    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
    $endDate = $date . "-" . $number_of_days;

    //select sales team info
    $salesTeam = WorkTeamInfo::where('team_type', WorkTeamType::get()->key('SEO Sales'))
      ->get();

    $teamUsers = [];

    foreach ($salesTeam as $idx => $row) {

      $teamLeaders = [];

      foreach ($row->workTeamMembers as $row2) {
        $teamUsers[$idx]['team_members'][] = $row2->user_id;

        if ($row2->member_type === 'team_leader') {
          $teamLeaders[] = $row2->username->username;
        }
      }

      $teamUsers[$idx]['team_id'] = $row->wt_id;
      $teamUsers[$idx]['team_name'] = $row->team_name;
      $teamUsers[$idx]['team_leaders'] = ' [ ' . implode(', ', $teamLeaders) . ' ]';
    }


    foreach ($teamUsers as $idx => $row) {

      $orders = OrderRecords::select(
        'order_date',
        DB::raw('sum(number_of_order) as total_order')
      )
        ->whereDate('order_date', '>=', $startDate)
        ->whereDate('order_date', '<=', $endDate)
        ->whereIn('user_id', $row['team_members'])
        ->groupBy('order_date')
        ->orderBy('order_date', 'asc')
        ->get();

      $ordArr = [];

      //making order month as key
      foreach ($orders as $row) {
        $ordArr[$row->order_date] = $row;
      }



      /**
       * :::::::::::::::::::::::::::::::::::::
       * Below process is for day wise order
       * :::::::::::::::::::::::::::::::::::::
       */


      //month orders
      $orders = [];

      //total orders in a month ny team
      $totalOrders = 0;

      $dateArr = explode('-', $endDate);

      //create array for full month order
      for ($i = 1; $i <= $dateArr[2]; $i++) {

        //formatting loop date
        $crrDate = date('Y-m-d', strtotime("{$dateArr[0]}-{$dateArr[1]}-{$i}"));

        if (!empty($ordArr[$crrDate])) {
          $orders[] = [
            'date' => date('d M', strtotime($crrDate)),
            'orders' => $ordArr[$crrDate]->total_order,
          ];
          $totalOrders += $ordArr[$crrDate]->total_order;
        } else {
          $orders[] = [
            'date' => date('d M', strtotime($crrDate)),
            'orders' => 0,
          ];
        }
      }



      //storing order data into array
      $teamUsers[$idx]['orders'] = $orders;
      $teamUsers[$idx]['total_orders'] = $totalOrders;
    }




    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $teamUsers;
    $return['month'] = date('F Y', strtotime($date));

    return response()->json($return);
  }

    /**
   * Get month website
   */
  public function fetchMonthWebsite(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'sales_month' => "nullable|date",
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('sales_month');

      return response()->json($return);
    }

    $sales_month = $request->input('sales_month');


    $isCurrentMonth = false;
    $workingDays = 0;


    if (!empty($sales_month)) {
      $date = $sales_month;

      if (strtotime($sales_month) > strtotime(date('Y-m'))) {
        $return['code'] = 101;
        $return['msg'] = "Requested month is future date.";

        return response()->json($return);
      }


      //check current month
      if ($date == date('Y-m')) {
        $isCurrentMonth = true;
        $workingDays = ((int)date('j') - 1);
      }
    } else {
      //getting current year and month
      $date = date('Y-m');


      $isCurrentMonth = true;
      $workingDays = ((int)date('j') - 1);
    }



    //start date
    $startDate = "{$date}-01";


    //calculating end date
    $number_of_days = cal_days_in_month(CAL_GREGORIAN, date('m', strtotime($date)), date('Y', strtotime($date)));
    $endDate = $date . "-" . $number_of_days;


    //getting users list of all SEOs
    $websiteInfo = WebsiteInfo::select('id', 'site_name')
      ->orderBy('site_name', 'ASC')
      ->get();


    $orders = [];

    //creating object for month average
    $monthAvg = new PerformanceBySeo();

    $count = 0;

    foreach ($websiteInfo as $row) {

      $order = OrderRecords::select(
        'user_id',
        DB::raw('sum(number_of_order) as total_order')
      )
        ->whereDate('order_date', '>=', $startDate)
        ->whereDate('order_date', '<=', $endDate)
        ->where('website_id', $row->id)
        ->groupBy('website_id')
        ->orderBy('total_order', 'desc')
        ->first();

      if (!empty($order)) {

        $orders[$count] = [
          'user_id' => $row->website_id,
          'username' => $row->site_name,
          'orders' => $order->total_order
        ];
      } else {
        $orders[$count] = [
          'user_id' => $row->website_id,
          'username' => $row->site_name,
          'orders' => 0
        ];
      }



      /**
       * Find order Zone
       */
      if ($isCurrentMonth) {
        $tempAvgArr = $monthAvg->monthAvg($orders[$count]['orders'], $monthAvg->getTagetOrdersAvg($workingDays, $number_of_days));

        $orders[$count] = array_merge($orders[$count], $tempAvgArr);
      } else {
        $tempAvgArr = $monthAvg->month($orders[$count]['orders']);

        $orders[$count] = array_merge($orders[$count], $tempAvgArr);
      }


      $count++;
    }



    //array short by top orders
    array_multisort(array_column($orders, 'orders'), SORT_DESC, $orders);



    $return['code'] = 200;
    $return['msg'] = 'Data found';
    $return['data'] = $orders;
    $return['month'] = date('F Y', strtotime($date));

    return response()->json($return);
  }
}
