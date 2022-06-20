<?php

namespace App\Http\Controllers\Admin;

use App\Classes\ContentHoursCalculation;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\ContentWriterTask;
use App\Models\NewContentCount;
use App\Models\NewContentEdits;
use App\Models\NewContentTask;
use App\Models\NewContentTimestamps;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class WorkReportCWCtrl extends Controller
{
  public function viewReport()
  {
    $users = Users::select('user_id', 'username', 'designation', 'post')
      ->where('status', 1)
      ->where('post', '1')
      ->orderBy('post', 'ASC')
      ->orderBy('username', 'ASC')
      ->get();

    return view('admin.work_report.cw_work_report', ['users' => $users]);
  }

  /**
   * Get Year sales data
   */
  public function fetchMonthCount(Request $request)
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
    $user = $request->input('user_list');
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

    // $orders = NewContentTask::select(
    //     'assign_date',
    //   DB::raw('sum(word_count) as total_counts'),
    //   // DB::raw("DATE_FORMAT(order_date,'%Y-%M-%d') as ord_date")
    // )->where('assign_to',$user)
    //   ->whereDate('assign_date', '>=', $startDate)
    //   ->whereDate('assign_date', '<=', $endDate)
    //   ->groupBy('assign_date')
    //   ->orderBy('assign_date', 'asc')
    //   ->get();

    $orders = NewContentCount::select(
      'date',
      DB::raw('sum(count) as total_counts')

      // DB::raw("DATE_FORMAT(order_date,'%Y-%M-%d') as ord_date")
    )->where('user_id', $user)
      ->whereDate('date', '>=', $startDate)
      ->whereDate('date', '<=', $endDate)
      ->groupBy('date')
      ->get();


    // dd($orders);
    // =============================================

    //   $content = NewContentTask::with(['assignToUser', 'contentEdits.timeLastUpdate'])
    //   ->where('status', '>=', 3)
    //   // ->where('request_by', TrackSession::get()->userId())
    //   ->where('id', $contentId)
    //   ->first();


    // $content->status_str = EditContentStatus::get()->value($content->status);
    // $content->contentEdits->content = htmlspecialchars_decode($content->contentEdits->content);
    // $content->done_word_count = Fns::init()->wordCount($content->contentEdits->content);


    // //getting and calculating total time taken on the content
    // $hoursArr = [
    //   'work_hours' => 0,
    //   'work_hours_arr' => 0,
    // ];
    // $timestamps = [];

    // if (!empty($timestamps = $content->contentEdits->contentTimestamps)) {
    //   $hoursCalculation = new ContentHoursCalculation();
    //   $hoursArr = $hoursCalculation->calculate($timestamps);
    // }


    // =============================================

    $ordArr = [];

    //making order month as key
    foreach ($orders as $row) {
      $ordArr[date('Y-m-d', strtotime($row->date))] = $row;
      //   dd($ordArr);
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
      //  dd($ordArr[$crrDate]);
      if (!empty($ordArr[$crrDate])) {
        $orders[] = [
          'date' => date('d M', strtotime($crrDate)),
          // 'order_date' => $ordArr[$crrDate]->order_date,
          //   'orders' => $ordArr[$crrDate]->word_count,
          'orders' => $ordArr[$crrDate]->total_counts,
          'count' => $ordArr[$crrDate]->count,
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

  public function fetchData(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'date' => "date",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('date');

      return response()->json($return);
    }

    // $user = $request->input('user_list');
    $date = $request->input('date');
    $data_new = [];
    $t = [];
    // $hr = [];
    // $hoursArrs = [];
    // $times = [];
    $data = NewContentCount::whereDate('date', $date)->orderBy('id', 'DESC')->get();
    // $tempList = [];


    // $tempList = [];
    // $times = DB::table('new_content_timestamps')
    //   ->select('new_content_timestamps.id', 'new_content_timestamps.start_time', 'new_content_timestamps.end_time', 'new_content_count.date', 'new_content_count.user_id', 'new_content_count.count',)
    //   ->leftJoin('new_content_edits', 'new_content_edits.id', '=', 'new_content_timestamps.new_content_edits_id')
    //   ->leftJoin('new_content_count', 'new_content_count.content_id', '=', 'new_content_edits.new_content_id')
    //   // ->leftJoin(DB::raw($latestCount), 'new_content_timestamps.start_time', '=', 'new_content_count.date')
    //   ->whereDate('new_content_timestamps.start_time', $date)
    //   ->whereDate('new_content_timestamps.end_time', $date)
    //   // ->groupBy('start_time')
    //   ->orderBy('new_content_timestamps.start_time', 'ASC')
    //   ->get();

    // foreach ($times as $key => $row) {
    //   if (empty($tempList[$row->id])) {
    //     $tempList[$row->id] = $row;
    //     $t[] = $row->user_id;
    //   } else {
    //     unset($times[$key]);
    //   }
    //   $latestCount = DB::table('new_content_count')
    //     ->select('date', DB::raw('SUM(count) as total_count'))
    //     ->where('user_id', $row->user_id)
    //     ->whereDate('date', $date)
    //     ->groupBy('date')
    //     ->first();
    //   $row->total_counts = $latestCount->total_count;
    // }

    // unset($tempList);

    //  dd($times);


    // $timeds = DB::table('new_content_timestamps')
    //         ->leftJoinSub($latestCount, 'latestCount', function ($join) {
    //             $join->on('new_content_timestamps.start_time', '=', 'latestCount.date');
    //         });
    // dd($timeds);

    // $hoursCalculations = new ContentHoursCalculation();
    // $hoursArrs = $hoursCalculations->calculate($times);
    // $hr = $hoursArrs['total_working_hour_plane'];
    // $data_new[] = [
    //   "count_new" => $latestCount->total_count,
    //   'hr' => $hr,
    //   'date' => $latestCount->date
    // ];

    // dd($data_new);
    // foreach ($times as $key => $row) {
    //   if (empty($tempList[$row->id])) {
    //     $tempList[$row->id] = $row;

    //   } else {
    //     unset($times[$key]);

    //   }


    //   $users = Users::select('username')->where('user_id', $row->user_id)
    //     ->first();
    //   $username = $users->username;
    //   $hoursCalculations = new ContentHoursCalculation();
    //   $hoursArrs = $hoursCalculations->calculate($tempList);
    //   $hr = $hoursArrs['total_working_hour_plane'];
    //   // $row->hr = $hr;
    //   $data[] = [
    //     'username' => $username,
    //     'count' => $row->count,
    //     'date' => $row->date,
    //     'hr'=>$hr
    //   ];

    // }

    // unset($tempList);

    // dd($data);

    foreach ($data as $row) {

      $users = Users::where('user_id', $row->user_id)
        ->first();
      $row->username = $users->username;

      $getEdit = NewContentEdits::where('new_content_id', $row->content_id)->first();
      // dd($getEdit);
      $idds = '';
      $idds = $getEdit->id;


      if (!empty($getEdit->id)) {

        $times = NewContentTimestamps::where('new_content_edits_id', $idds)->whereDate('start_time', $date)->get();


        $hoursCalculations = new ContentHoursCalculation();
        $hoursArrs = $hoursCalculations->calculate($times);
        $hr = $hoursArrs['total_working_hour_plane'];
        // dd($hr);
      } else {
        $return['code'] = 200;
        $return['msg'] = 'No Data found';
      }
      $row->hrArr = $hoursArrs['work_hours_arr'];
      $row->hr = $hr;
    }
    $tempData = [];

    foreach ($data as $key => $row_new) {
      
    }

    if ($data) {
      $return['code'] = 200;
      $return['msg'] = 'Content Data found';
      $return['data'] = $data;
      // $return['hr'] =  $t;

    } else {
      $return['code'] = 101;
      $return['msg'] = 'No Data found';
    }


    return response()->json($return);
  }
}
