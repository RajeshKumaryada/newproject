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
        ->where('post','1')
        ->orderBy('post', 'ASC')
        ->orderBy('username', 'ASC')
        ->get();

        return view('admin.work_report.cw_work_report',['users' => $users]);
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
    )->where('user_id',$user)
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
    $data = [];
    $data = NewContentCount::whereDate('date',$date)->orderBy('id','DESC')->get();
    // dd($data);
   $t = [];
   $hr=[];
   $hoursArrs = [];
   $times= '';
    foreach($data as $row){
     
      $users = Users::
      where('user_id',$row->user_id)
      ->first();
      $row->username = $users->username;
      
      $getEdit = NewContentEdits::where('new_content_id',$row->content_id)->first();
      $idds = '';
      $idds = $getEdit->id;


      if(!empty($getEdit->id)){
     
        $times = NewContentTimestamps::where('new_content_edits_id',$idds)->whereDate('start_time',$date)->get();
        // dd($times);

        foreach($times as $rows){
          $hoursCalculations = new ContentHoursCalculation();
          $hoursArrs = $hoursCalculations->calculate($rows);
          $hr[] = $hoursArrs['total_working_hour_plane'];
          
        }  
       
      }else{
        $return['code'] = 200;
        $return['msg'] = 'No Data found';
      }
      // dd($hr);
      
      // $row->hr = $hr;
      
 
    }
    // dd($hr);
    if($data){
      $return['code'] = 200;
      $return['msg'] = 'Content Data found';
      $return['data'] = $data;
      // $return['hr'] =  $t;
   
    }else{
      $return['code'] = 101;
      $return['msg'] = 'No Data found';

    }


    return response()->json($return);
  }

  

}
