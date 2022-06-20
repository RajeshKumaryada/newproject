<?php

namespace App\Http\Controllers\Admin\OrderManagement;


use App\Http\Controllers\Controller;


class OrderDashboardCtrl extends Controller
{

  /**
   * Order Dashboard
   */
  public function dashboard()
  {
    return view('admin.order_management.order_dashboard');
  }




  /**
   * Order Dashboard of Sales Team
   */
  public function dashboardBySalesTeam()
  {
    return view('admin.order_management.order_dashboard_sales_team');
  }
}
