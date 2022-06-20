<?php

namespace App\Http\Controllers\WorkPortal\SeoExecutive;


use App\Http\Controllers\Controller;


class LinkReportCtrl extends Controller
{

  /**
   * View for Link Report
   */
  public function viewSeoLinkReport()
  {
    return view('work_portal.seo_executive.seo_link_report');
  }
}
