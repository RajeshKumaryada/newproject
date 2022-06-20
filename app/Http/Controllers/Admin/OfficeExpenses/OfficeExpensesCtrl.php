<?php

namespace App\Http\Controllers\Admin\OfficeExpenses;

use App\Http\Controllers\Controller;
use App\Models\OfficeExpenses;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OfficeExpensesCtrl extends Controller
{
    /**
     * View Form
     */
    public function viewForm()
    {
        $users = Users::where('department', '1')
            ->where('status', '1')
            ->where('username', '<>', 'admin')
            ->orderBy('post', 'ASC')
            ->get();

        return view('admin.manage_office_expenses.office_expenses_manage', ['users' => $users]);
    }

    /**
     * Add Expenses
     */
    public function addForm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_list' => "required",
                'date' => "required",
                'particular' => "required",
                'type' => "required",
                'amount' => "required"
            ]
        );

        if ($validator->fails()) {

            $return['code'] = 100;
            $return['msg'] = 'error';
            $return['err'] = $validator->errors();

            return response()->json($return);
        }

        $user = implode('', $request->user_list);
        $date = $request->date;
        $particular = $request->particular;
        $type = $request->type;
        $amount = $request->amount;
  
        $dataExpense = new OfficeExpenses();

        if($type == 1){
            $dataExpense->deposit = $amount;
        }

        if($type == 2){
            $dataExpense->expense = $amount;
        }

        $dataExpense->user_id = $user;
        $dataExpense->date = $date;
        $dataExpense->particular = $particular;
        $dataExpense->type = $type;
        $dataExpense->status = 1;

        if ($dataExpense->save()) {
            $return['code'] = 200;
            $return['msg'] = 'Add Expenses successfully';
        } else {
            $return['code'] = 100;
            $return['msg'] = 'error';
        }
        return response()->json($return);
    }

    /**
     * View Office Expenses
     */

    public function viewOfficeExpenses()
    {
        $users = Users::where('department', '1')
            ->where('status', '1')
            ->where('username', '<>', 'admin')
            ->orderBy('post', 'ASC')
            ->get();

        return view('admin.manage_office_expenses.view_office_expenses', ['users' => $users]);
    }

    /**
     * Fetch Expenses
     */
    public function fetchOfficeExpenses(Request $request)
    {
        
        $user = trim(implode('', $request->input('user_list')));
        $date = $this->firstLastDate($request->input('date'));
        $startDate = $date[0];
        $endDate = $date[1];
        
      
            $expenses = OfficeExpenses::where('user_id',$user)
            ->whereDate('date', '>=', $startDate)
            ->whereDate('date', '<=', $endDate)
            ->orderBy('id', 'desc')
            ->get();

            $datadep = DB::table('office_expenses')
             ->select(DB::raw('sum(deposit) as dep_total'))
             ->whereDate('date', '>=', $startDate)
             ->whereDate('date', '<=', $endDate)
             ->where('user_id',$user)
             ->get();

             $dataexp = DB::table('office_expenses')
             ->select(DB::raw('sum(expense) as exp_total'))
             ->whereDate('date', '>=', $startDate)
             ->whereDate('date', '<=', $endDate)
             ->where('user_id',$user)
             ->get();

             $datadepYear = DB::table('office_expenses')
             ->select(DB::raw('sum(deposit) as dep_all'))
             ->where('user_id',$user)
             ->get();
            
             foreach($datadepYear as $row){
               $d =  $row->dep_all;
             }
            
            
             $dataexpYear = DB::table('office_expenses')
             ->select(DB::raw('sum(expense) as exp_all'))
             ->where('user_id',$user)
             ->get();

             foreach($dataexpYear as $row){
                $e =  $row->exp_all;
              }
             
               $total = $d - $e;
           
            $return['code'] = 200;
            $return['msg'] = 'Data Found';
            $return['data'] = $expenses;
            $return['datadep'] = $datadep;
            $return['dataexp'] = $dataexp;
            $return['dataexpYear'] = $dataexpYear;
            $return['datadepYear'] = $datadepYear;
            $return['total'] = $total;

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
