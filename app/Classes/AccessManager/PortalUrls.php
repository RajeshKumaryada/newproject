<?php

namespace App\Classes\AccessManager;


use Illuminate\Support\Facades\Route;

class PortalUrls
{

  /**
   * return the urls which are used for admin
   */
  public function getAdminUrls()
  {
    $adminUrls = [];
    foreach (Route::getRoutes()->getRoutes() as $route) {

      $uri = $route->uri;
      $uri = explode('/', $uri);

      if ($uri[0] === 'admin') {
        $adminUrls[] = $route->uri;
      }
    }

    return $adminUrls;
  }
}