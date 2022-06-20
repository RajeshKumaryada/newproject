<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;

use App\Classes\DuplicateLinks;
use App\Classes\TrackSession;
use App\Http\Controllers\Controller;
use App\Models\SeoTaskList;
use App\Models\SeoWorkReport;
use App\Models\SeoWorkReportDuplicateUrl;
use App\Models\SeoWorkReportImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

// use PhpOffice\Reader\Xlsx;
// use PhpOffice\Reader;

class SeoSubmitWorkReportCtrl extends Controller
{

  /**
   * View
   */
  public function viewForm()
  {

    //check for session
    if (request()->session()->has('duplicateLinks')) {
      return redirect('/seo/submit-work-report/url-answer');
    }


    //check for pending reasons in database
    // TrackSession::get()->userId();

    $dupliLinks = new DuplicateLinks();
    $returnRes = $dupliLinks->checkPendingReasons(TrackSession::get()->userId());
    $dupliLinks = null;

    if (!empty($returnRes)) {

      request()->session()->put('duplicateLinks', serialize($returnRes));
      request()->session()->put('duplicateLinksMsg', "Please provide us pending URLs Justification. After you can submit new work report.");

      return redirect('/seo/submit-work-report/url-answer');
    }


    return view('work_portal.seo_executive.submit_work_report');
  }



  /**
   * View for submit duplicate URL Answer
   */
  public function viewDuplicateUrlAnswer()
  {

    if (!request()->session()->has('duplicateLinks')) {
      return redirect('/seo/submit-work-report');
    }

    $duplicateIds = request()->session()->get('duplicateLinks');
    $duplicateIds = unserialize($duplicateIds);

    $dupLinksObj = new DuplicateLinks();
    $sqlRow = $dupLinksObj->selectDuplicate($duplicateIds, TrackSession::get()->userId());

    $duplicateLinksMsg = request()->session()->get('duplicateLinksMsg');


    return view('work_portal.seo_executive.submit_work_report_url_answer', ['sqlRow' => $sqlRow, 'duplicateLinksMsg' => $duplicateLinksMsg]);
  }


  /**
   * 
   */
  public function fetchWorkReport()
  {
    $seoWr = SeoWorkReport::with(['seoTaskList'])
      ->where('user_id', TrackSession::get()->userId())
      ->whereDate('date', date('Y-m-d'))
      ->get();


    if (empty($seoWr)) {
      $return['code'] = 100;
      $return['msg'] = 'No Data';

      return response()->json($return);
    }


    $return['code'] = 200;
    $return['msg'] = 'Data found.';
    $return['data'] = $seoWr;


    return response()->json($return);
  }


  /**
   * AJAX call
   * POST method
   * Submit work report via Form
   */
  public function submitReportViaForm(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'task_details' => "required|numeric|min:1|max:999999",
        // 'efile' => "nullable|mimes:jpeg,png,jpg",
        'title.*' => "required",
        'url.*' => 'required|url'
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $current_date = date("Y-m-d H:i:s");
    $task = $request->input('task_details');
    $trackSession = TrackSession::get();


    //getting task name
    //getting task exclude from duplicate url check
    $task_name = null;
    $exclude_from_url_check = null;
    $img_id = null;


    $taskExclude = SeoTaskList::select('task', 'exclude_from_url_check')
      ->where('id', $task)
      ->first();

    if (empty($taskExclude)) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = ['task_details' => ["Invalid Task"]];

      return response()->json($return);
    } else {
      $task_name = $taskExclude->task;
      $exclude_from_url_check = $taskExclude->exclude_from_url_check;
    }





    //:::::::::::::::::::::::::::
    //for other task, id is 36
    //:::::::::::::::::::::::::::

    if ($task === '36') {

      $ohter_task_text = $request->input('ohter_task_text');

      if (empty($ohter_task_text)) {
        $return['code'] = 100;
        $return['msg'] = 'error';
        $return['err'] = ['ohter_task_text' => ["Describe your work !"]];

        return response()->json($return);
      }

      $in = SeoWorkReport::insert([
        'user_id' => $trackSession->userId(),
        'date' => $current_date,
        'task_id' => $task,
        'title' => $ohter_task_text
      ]);

      if ($in) {

        $return['code'] = 200;
        $return['msg'] = "Work Report submitted successfully.";
        $return['data'] = [
          [
            'date' => $current_date,
            'seo_task_list' => ['task' => $task_name],
            'title' => $ohter_task_text
          ]
        ];


        return response()->json($return);
      } else {
        $return['çode'] = 103;
        $return['msg'] = "Error: DB Insert.";

        return response()->json($return);
      }
    }



    //:::::::::::::::::::::::::::
    //for On-page task, id is 33
    //:::::::::::::::::::::::::::
    else if ($task === '33') {

      // echo 33;

      $validator = Validator::make(
        $request->all(),
        [
          'task_details' => "required|numeric|min:1|max:999999",
          'screenshots' => 'required',
          'screenshots.*' => 'mimes:jpeg,png,jpg',
          'title.*' => "required",
          'url.*' => 'required|url'
        ]
      );

      if ($validator->fails()) {

        $return['code'] = 100;
        $return['msg'] = 'error';
        $return['err'] = $validator->errors();

        return response()->json($return);
      }

      if ($request->hasfile('screenshots')) {

        $imageData = [];
        $img_id = uniqid();

        foreach ($request->file('screenshots') as $file) {
          // $name = time() . '.' . $file->extension();
          // $fileName = "on_page_{$trackSession->userId()}_" . time() . ".{$file->extension()}";

          // $file->move("/work_report_images/", $fileName);
          // $file->move(public_path().'/files/', $name); 
          // $imageData[] = $file->store('work_report_images');
          $image = $file->storePublicly('work_report_images', 'public');
          // storePublicly
          // $imageData[] = $fileName;

          $imageData[] = [
            'date' => $current_date,
            'image' => $image,
            'user_id' => $trackSession->userId(),
            'work_report_id' => $img_id
          ];
        }
      } else {
        $return['code'] = 100;
        $return['msg'] = 'error';
        $return['err'] = ['screenshots' => ['Upload files !']];

        return response()->json($return);
      }


      // print_r($imageData);

      SeoWorkReportImages::insert($imageData);


      // exit();

      // $fileExt = $request->file('efile')->extension();
      // $mimeType = $request->file('efile')->getMimeType();

      // $fileName = "work_report_{$trackSession->userId()}_{$request->input('task_excel')}_" . date('Y_m_d_H_i_s') . ".{$fileExt}";

      // $filePath = $request->file('screenshots')->storeAs('work_report_files', $fileName);
    }





    //:::::::::::::::::::::::::::
    //when url is not empty
    //check duplicate links
    //:::::::::::::::::::::::::::

    //this all vars contains array value
    $title = $request->input('title');
    $email = $request->input('email');
    $username = $request->input('username');
    $password = $request->input('password');
    $url = $request->input('url');

    $total_input_rows = count($title);



    $sql = [];
    $responseData = [];

    for ($i = 0; $i < $total_input_rows; $i++) {

      $sql[] = [
        'user_id' => $trackSession->userId(),
        'date' => $current_date,
        'task_id' => $task,
        'title' => $title[$i],
        'email' => $email[$i],
        'username' => $username[$i],
        'password' => $password[$i],
        'url' => urlencode($url[$i]),
        'img_id' => $img_id
      ];

      //array for response
      $responseData[] = [
        'date' => $current_date,
        'seo_task_list' => ['task' => $task_name],
        'title' => stripslashes($title[$i]),
        'email' => stripslashes($email[$i]),
        'username' => stripslashes($username[$i]),
        'password' => stripslashes($password[$i]),
        'url' => urlencode($url[$i]),
      ];
    }


    if (empty($sql)) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = ['url' => ["Empty inputs are not allowed."]];

      return response()->json($return);
    }


    if (!empty($url)) {

      $duplicateLinks = new DuplicateLinks();

      $checkList = $duplicateLinks->check($url, $trackSession->userId());
    }


    //insert data
    $seoWr = SeoWorkReport::insert($sql);


    if ($seoWr) {

      //this will store duplicate links IDs
      $listFounded = [];

      $last_insert_id = DB::getPdo()->lastInsertId();

      if (!empty($checkList[0])) {


        foreach ($checkList[0] as $key => $val) {
          $listFounded[] = [
            'array_key' => $key,
            'work_report_id' => ($last_insert_id + $key)
          ];
        }

        //insert record
        $duplicateLinks->insertDuplicate($listFounded, $trackSession->userId());

        if (empty($exclude_from_url_check)) {
          //
          $request->session()->put('duplicateLinks', serialize($listFounded));
          // $_SESSION['duplicateLinks'] = serialize($listFounded);
        } else {
          //when no need to ask reason
          $listFounded = [];
        }
      }

      $return['code'] = 200;
      $return['msg'] = "Work Report submitted successfully.";
      $return['data'] = $responseData;
      $return['is_duplicate'] = $listFounded;


      return response()->json($return);
    } else {
      $return['çode'] = 103;
      $return['msg'] = "Error: DB Insert.";

      return response()->json($return);
    }
  }


  /**
   * AJAX call
   * POST method
   * Submit work report via excel
   */
  public function submitReportViaExcel(Request $request)
  {
    //$request->efile->move(public_path('uploads'), $fileName);
    //application/vnd.openxmlformats-officedocument.spreadsheetml.sheet

    $validator = Validator::make(
      $request->all(),
      [
        'task_excel' => "required|numeric|min:1|max:999999",
        'efile' => "required|mimes:xlx,xlsx,xls"
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $allowedFileType = [
      'application/vnd.ms-excel',
      'text/xls',
      'text/xlsx',
      'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    ];


    $trackSession = TrackSession::get();


    // $file = $request->file('efile');
    $fileExt = $request->file('efile')->extension();
    $mimeType = $request->file('efile')->getMimeType();


    //check file mime type
    if (!in_array($mimeType, $allowedFileType)) {


      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = ['efile' => ["This file is not allowed."]];

      return response()->json($return);
    }

    $fileName = "work_report_{$trackSession->userId()}_{$request->input('task_excel')}_" . date('Y_m_d_H_i_s') . ".{$fileExt}";

    $filePath = $request->file('efile')->storeAs('work_report_files', $fileName);


    // $contents = Storage::download($filePath, $fileName, ['content-type',  $mimeType]);
    // $contents = asset('public/storage/' . $filePath);

    // $contents = $request->DOCUMENT_ROOT;
    // $contents = File::get(storage_path('app/' . $filePath));

    $contents = (storage_path('app/' . $filePath));


    $Reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();

    $spreadSheet = $Reader->load($contents);
    $excelSheet = $spreadSheet->getActiveSheet();
    $spreadSheetAry = $excelSheet->toArray();


    $sql = null;
    $current_date = date("Y-m-d H:i:s");
    $urlArray = [];
    // $date = date("Y-m-d", strtotime($current_date));
    $responseData = array();


    //getting task name
    //getting task exclude from duplicate url check
    $task_name = null;
    $exclude_from_url_check = null;


    $taskExclude = SeoTaskList::select('task', 'exclude_from_url_check')
      ->where('id', $request->input('task_excel'))
      ->first();

    if (!empty($taskExclude)) {
      $task_name = $taskExclude->task;
      $exclude_from_url_check = $taskExclude->exclude_from_url_check;
    }

    //:::::::::::::::::::::::::::::::::::::::::::
    // Extracting data from excel
    //:::::::::::::::::::::::::::::::::::::::::::

    $sheetRowCount = count($spreadSheetAry);

    for ($i = 1; $i < $sheetRowCount; $i++) {

      $title = "";
      if (!empty($spreadSheetAry[$i][0])) {
        $title = $this->clean($spreadSheetAry[$i][0]);
      }

      $email = "";
      if (!empty($spreadSheetAry[$i][1])) {
        $email = $this->clean($spreadSheetAry[$i][1]);
      }

      $username = "";
      if (!empty($spreadSheetAry[$i][2])) {
        $username = $this->clean($spreadSheetAry[$i][2]);
      }

      $password = "";
      if (!empty($spreadSheetAry[$i][3])) {
        $password = $this->clean($spreadSheetAry[$i][3]);
      }

      $url = "";
      if (!empty($spreadSheetAry[$i][4])) {
        $url = $this->clean($spreadSheetAry[$i][4]);
        $urlArray[] = $url;
        $url = urlencode($url);
      }


      if (!empty($title) && !empty($url)) {

        $sql[] = [
          'user_id' => $trackSession->userId(),
          'date' => $current_date,
          'task_id' => $request->input('task_excel'),
          'title' => $title,
          'email' => $email,
          'username' => $username,
          'password' => $password,
          'url' => $url
        ];

        //array for response
        $responseData[] = [
          'date' => $current_date,
          'seo_task_list' => ['task' => $task_name],
          'title' => stripslashes($title),
          'email' => stripslashes($email),
          'username' => stripslashes($username),
          'password' => stripslashes($password),
          'url' => $url,
        ];
      }
    }


    //:::::::::::::::::::::::::::
    //when url is not empty
    //check duplicate links
    //:::::::::::::::::::::::::::

    if (!empty($urlArray)) {

      // require_once("./classes/DuplicateLinks.php");

      $duplicateLinks = new DuplicateLinks();

      $checkList = $duplicateLinks->check($urlArray, $trackSession->userId());
    }


    if (empty($sql)) {
      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = ['efile' => ["Empty file is not allowed."]];

      return response()->json($return);
    }

    //insert data
    $seoWr = SeoWorkReport::insert($sql);

    if ($seoWr) {

      //this will store duplicate links IDs
      $listFounded = [];

      $last_insert_id = DB::getPdo()->lastInsertId();

      if (!empty($checkList[0])) {


        foreach ($checkList[0] as $key => $val) {
          $listFounded[] = [
            'array_key' => $key,
            'work_report_id' => ($last_insert_id + $key)
          ];
        }

        //insert record
        $duplicateLinks->insertDuplicate($listFounded, $trackSession->userId());

        if (empty($exclude_from_url_check)) {
          //
          $request->session()->put('duplicateLinks', serialize($listFounded));
          // $_SESSION['duplicateLinks'] = serialize($listFounded);
        } else {
          //when no need to ask reason
          $listFounded = [];
        }
      }

      $return['code'] = 200;
      $return['msg'] = "Work Report submitted successfully.";
      $return['data'] = $responseData;
      $return['is_duplicate'] = $listFounded;


      return response()->json($return);
    } else {
      $return['çode'] = 103;
      $return['msg'] = "Error: DB Insert.";

      return response()->json($return);
    }
  }



  /**
   * AJAX call
   * POST method
   * Submit duplicate URL Answer
   */
  public function submitDuplicateUrlAnswer(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'reason.*' => "required|min:2",
      ]
    );

    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = "Please provide all reasons.";
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    $reasons = $request->input('reason');

    // dd($reasons);


    $duplicateIds = request()->session()->get('duplicateLinks');
    $duplicateIds = unserialize($duplicateIds);



    $sql = "";
    $reasonCount = 0;
    $updateData = [];

    foreach ($duplicateIds as $row) {


      $temp = $reasons[$row['work_report_id']];

      $updateData[] = [
        'work_report_id' => $row['work_report_id'],
        'reason' => $temp
      ];

      $reasonCount++;
      //}
    }

    if (count($duplicateIds) !== $reasonCount) {
      $return['code'] = 100;
      $return['msg'] = "Please provide all reasons.";


      return response()->json($return);
    }

    $updateCount = 0;

    foreach ($updateData as $row) {
      $updateCount += SeoWorkReportDuplicateUrl::where('work_report_id', $row['work_report_id'])->update(['reason' => $row['reason']]);
    }


    if (count($duplicateIds) === $updateCount) {

      $return['code'] = 200;
      $return['msg'] = "Your reason has been saved.";

      $request->session()->forget('duplicateLinks');

      return response()->json($return);
    } else {
      $return['code'] = 100;
      $return['msg'] = "DB Update Error.";


      return response()->json($return);
    }
  }



  private function clean($str)
  {
    if (!empty($str)) {
      $str = htmlspecialchars(trim($str));
      return addslashes($str);
    }
    return null;
  }
}
