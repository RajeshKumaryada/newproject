<?php

namespace App\Classes\Checklist;

use Illuminate\Support\Facades\DB;

class ChecklistForUsers
{

  public function find($userId)
  {

    $checklistGroups = DB::table('checklist_group_users')->select('checklist_group.*', 'checklist_group_users.user_id')
      ->join('checklist_group', 'checklist_group_users.checklist_group_id', '=', 'checklist_group.checklist_group_id')
      ->orderBy('checklist_group.group_name', 'ASC')
      ->where('checklist_group_users.user_id', $userId)
      ->get();


    if (empty($checklistGroups)) {
      return null;
    }


    $checklist_group_id = [];

    foreach ($checklistGroups as $row) {
      $checklist_group_id[] = $row->checklist_group_id;
    }

    $checklist = DB::table('checklist')
      ->whereIn('checklist_group_id', $checklist_group_id)
      ->where('status', 1)
      ->orderBy('checklist_name', 'ASC')
      ->get();

    return $checklist;
  }


  public static function init()
  {
    return new self();
  }
}
