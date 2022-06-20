<?php

namespace App\Http\Controllers\Admin\OrderManagement;

use App\Http\Controllers\Controller;
use App\Models\OrderRecords;
use App\Models\Users;
use App\Models\WebsiteInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderManageCtrl extends Controller
{

  /**
   * View for add order record
   */
  public function viewAddOrderRecord()
  {

    $users = Users::where('user_id', '!=', 1)->where('post', 4)->orderBy('username', 'asc')->get();

    $websites = WebsiteInfo::orderBy('site_name', 'asc')->get();

    return view('admin.order_management.order_record', ['users' => $users, 'websites' => $websites]);
  }



  /**
   * view for edit Order Record
   */
  public function editOrderRecord($ordId)
  {
    //decrypt the value
    $orderId = decrypt($ordId);

    //check the order
    $ordInfo = OrderRecords::find($orderId);

    if (empty($ordInfo)) {

      abort(404);
      // $return['code'] = 101;
      // $return['msg'] = "Invalid Delete ID.";

      // return response()->json($return);
    }


    $users = Users::where('user_id', '!=', 1)->where('post', 4)->orderBy('username', 'asc')->get();

    $websites = WebsiteInfo::orderBy('site_name', 'asc')->get();

    return view('admin.order_management.order_record_edit', ['users' => $users, 'websites' => $websites, 'ordInfo' => $ordInfo]);

    // if ($ordInfo->delete()) {

    //   $return['code'] = 200;
    //   $return['msg'] = "Data deleted successfully.";
    // } else {
    //   $return['code'] = 101;
    //   $return['msg'] = "Data delete operation failed.";
    // }

    // return response()->json($return);
  }


  /**
   * POST: add record to database
   */
  public function addOrderRecord(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'user_id' => "required|numeric|max:9999999999",
        'website_id' => "required|numeric|max:9999999999",
        'order_date' => "required|date",
        'number_of_order' => "required|numeric|max:999999",
        'order_number' => "nullable"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }

    //getting post values
    $userId = $request->input('user_id');
    $websiteId = $request->input('website_id');
    $orderDate = $request->input('order_date');
    $numberOfOrder = $request->input('number_of_order');
    $orderNumbers = $request->input('order_number');


    //check that is order info available in the table or not
    $checkOrderInfo = OrderRecords::where('user_id', $userId)
      ->where('website_id', $websiteId)
      ->whereDate('order_date', $orderDate)
      ->first();


    //if order info available, update it with previous record
    if (!empty($checkOrderInfo)) {
      $checkOrderInfo->number_of_order = $checkOrderInfo->number_of_order + $numberOfOrder;
      $checkOrderInfo->order_number = trim(($checkOrderInfo->order_number . ',' . $orderNumbers), ',');

      if ($checkOrderInfo->save()) {
        $return['code'] = 200;
        $return['msg'] = 'Previous Order Info updated succesfully.';
      } else {
        $return['code'] = 100;
        $return['msg'] = 'Previous Order found, but updation failed.';
      }

      return response()->json($return);
    }



    //if prevois record not found
    //insert new order record
    $dataInsert = [
      'user_id' => $userId,
      'website_id' => $websiteId,
      'order_date' => $orderDate,
      'number_of_order' => $numberOfOrder,
      'order_number' => empty($orderNumbers) ? '' : $orderNumbers,
    ];


    $insert = OrderRecords::insert($dataInsert);

    if ($insert) {
      $return['code'] = 200;
      $return['msg'] = 'Order record inserted succesfully.';
    } else {
      $return['code'] = 100;
      $return['msg'] = 'Order record insertion failed.';
    }

    return response()->json($return);
  }


  /**
   * POST: update record
   */
  public function updateOrderRecord(Request $request)
  {
    $validator = Validator::make(
      $request->all(),
      [
        'ord_id' => "required|numeric|max:9999999999",
        'user_id' => "required|numeric|max:9999999999",
        'website_id' => "required|numeric|max:9999999999",
        'order_date' => "required|date",
        'number_of_order' => "required|numeric|max:999999",
        'order_number' => "nullable"
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 100;
      $return['msg'] = 'error';
      $return['err'] = $validator->errors();

      return response()->json($return);
    }


    $ord_id = $request->input('ord_id');
    $user_id = $request->input('user_id');
    $order_number = $request->input('order_number');


    $dataUpdate = [
      'website_id' => $request->input('website_id'),
      'order_date' => $request->input('order_date'),
      'number_of_order' => $request->input('number_of_order'),
      'order_number' => empty($order_number) ? '' : $order_number,
    ];


    $update = OrderRecords::where('ord_id', $ord_id)
      ->where('user_id', $user_id)
      ->update($dataUpdate);


    if ($update) {
      $return['code'] = 200;
      $return['msg'] = "Data updated successfully.";
    } else {
      $return['code'] = 101;
      $return['msg'] = "No update found.";
    }

    return response()->json($return);
  }






  /**
   * delete Order Record
   */
  public function deleteOrderRecord(Request $request)
  {

    $validator = Validator::make(
      $request->all(),
      [
        'delete_id' => "required",
      ]
    );


    if ($validator->fails()) {

      $return['code'] = 101;
      $return['msg'] = $validator->errors()->get('delete_id');

      return response()->json($return);
    }


    //decrypt the value
    $orderId = decrypt($request->input('delete_id'));

    //check the order
    $ordInfo = OrderRecords::find($orderId);

    if (empty($ordInfo)) {
      $return['code'] = 101;
      $return['msg'] = "Invalid Delete ID.";

      return response()->json($return);
    }


    if ($ordInfo->delete()) {
      $return['code'] = 200;
      $return['msg'] = "Data deleted successfully.";
    } else {
      $return['code'] = 101;
      $return['msg'] = "Data delete operation failed.";
    }

    return response()->json($return);
  }




  public function fetchOrderRecord(Request $request)
  {

    ## Read value
    $draw = $request->get('draw');
    $start = $request->get("start");
    $rowperpage = $request->get("length"); // Rows display per page

    $columnIndex_arr = $request->get('order');
    $columnName_arr = $request->get('columns');
    $order_arr = $request->get('order');
    $search_arr = $request->get('search');

    $columnIndex = $columnIndex_arr[0]['column']; // Column index
    $columnName = $columnName_arr[$columnIndex]['data']; // Column name
    $columnSortOrder = $order_arr[0]['dir']; // asc or desc
    $searchValue = $search_arr['value']; // Search value

    // Total records
    $totalRecords = OrderRecords::select(
      DB::raw('count(*) as allcount')
    )->count();

    $totalRecordswithFilter = OrderRecords::select(
      DB::raw('count(*) as allcount')
    )->where('ord_id', 'like', '%' . $searchValue . '%')
      ->count();


    // Fetch records
    if (empty($searchValue)) {
      $records = OrderRecords::orderBy($columnName, $columnSortOrder)
        ->orderBy('order_records.ord_id', 'DESC')
        ->skip($start)
        ->take($rowperpage)
        ->get();
    } else {
      $records = OrderRecords::orderBy($columnName, $columnSortOrder)
        ->orderBy('order_records.ord_id', 'DESC')
        ->leftJoin('users', 'order_records.user_id', '=', 'users.user_id')
        ->leftJoin('website_info', 'order_records.website_id', '=', 'website_info.id')
        ->where('order_records.number_of_order', 'like', '%' . $searchValue . '%')
        ->orWhere('order_records.order_number', 'like', '%' . $searchValue . '%')
        ->orWhere('order_records.order_date', 'like', '%' . $searchValue . '%')
        ->orWhere('users.username', 'like', '%' . $searchValue . '%')
        ->orWhere('website_info.site_name', 'like', '%' . $searchValue . '%')
        ->select('order_records.*')
        ->skip($start)
        ->take($rowperpage)
        ->get();
    }



    $data_arr = [];

    $totalOrder = OrderRecords::select(DB::raw('sum(`number_of_order`) as total_order'))
      ->first();

    $count = $start + 1;


    foreach ($records as $record) {

      $ordId = encrypt($record->ord_id);

      $menu = "<div class='text-center'>
        <span class='user-badge text-primary'><i data-id='{$ordId}' class='fas fa-edit cur-ptr edit-order'></i></span>
        <span class='user-badge text-danger'><i data-id='{$ordId}' class='fas fa-trash cur-ptr delete-order'></i></span>
      </div>";



      $data_arr[] = [
        "ord_id" => $count,
        "menu" => $menu,
        "user_id" => $record->username->username,
        "website_id" => $record->websiteInfo->site_name,
        "order_date" => $record->order_date,
        'number_of_order' => $record->number_of_order,
        'order_number' => $record->order_number
      ];


      $count++;
    }

    $response = array(
      "draw" => intval($draw),
      "iTotalRecords" => $totalRecords,
      "iTotalDisplayRecords" => $totalRecordswithFilter,
      "aaData" => $data_arr,
      'total_order' => $totalOrder->total_order,
    );

    return response()->json($response);
  }
}
