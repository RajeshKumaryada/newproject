<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;



use App\Http\Controllers\Controller;



class OrderDashCtrl extends Controller
{

  /**
   * Order Dashboard
   */
  public function viewStatsByCalender()
  {
    return view('work_portal.seo_executive.stats_by_calender');
  }



  /**
   * Order Dashboard of Sales Team
   */
  public function viewStatsByTeams()
  {
    return view('work_portal.seo_executive.stats_by_teams');
  }
}
