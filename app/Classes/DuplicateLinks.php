<?php

namespace App\Classes;

use App\Models\SeoWorkReport;
use App\Models\SeoWorkReportDuplicateUrl;

use function PHPUnit\Framework\isNull;

class DuplicateLinks
{
  private $conn;

  public function __construct()
  {
  }


  /**
   * Check for Duplicate URL
   */
  public function check(array $urlList, $userId)
  {

    $duplicateIds = [];

    foreach ($urlList as $key => $row) {
      $url = urlencode($row);

      $sql = SeoWorkReport::select('seo_work_report.id')
        ->where('seo_task_list.exclude_from_url_check', 0)
        ->where('url', $url)
        ->where('user_id', $userId)
        ->leftJoin('seo_task_list', 'seo_work_report.task_id', '=', 'seo_task_list.id')
        ->count();


      if ($sql > 0) {
        $duplicateIds[$key] = true;
      }
    }

    return [$duplicateIds];
  }



  /**
   * 
   */
  public function insertDuplicate(array $list, $userId)
  {
    $sql = array();
    $date = date('Y-m-d H-i-s');
    foreach ($list as $key => $val) {
      $sql[] = [
        'user_id' => $userId,
        'work_report_id' => $val['work_report_id'],
        'created_at' => $date
      ];
    }

    return SeoWorkReportDuplicateUrl::insert($sql);;
  }


  public function selectDuplicate(array $list, $userId)
  {

    $inIds = [];

    foreach ($list as $row) {
      $inIds[] = $row['work_report_id'] . ",";
    }

    $sql = SeoWorkReportDuplicateUrl::where('user_id', $userId)
      ->whereIn('work_report_id', $inIds)
      ->get();

    return $sql;
  }


  public function checkPendingReasons($userId)
  {

    $listFounded = null;

    $sql = SeoWorkReportDuplicateUrl::where('seo_wr_duplicate_url.user_id', $userId)
      ->where(function ($sql) {
        return $sql->whereNull('reason')->orWhere('reason', '');
      })
      ->where('seo_task_list.exclude_from_url_check', 0)
      ->leftJoin('seo_work_report', 'seo_wr_duplicate_url.work_report_id', '=', 'seo_work_report.id')
      ->leftJoin('seo_task_list', 'seo_work_report.task_id', '=', 'seo_task_list.id')

      ->select('seo_wr_duplicate_url.work_report_id')
      ->get();

    if (!empty($sql)) {

      foreach ($sql as $key => $row) {
        $listFounded[] = [
          'array_key' => $key,
          'work_report_id' => ($row['work_report_id'])
        ];
      }
    }


    return $listFounded;
  }
}
