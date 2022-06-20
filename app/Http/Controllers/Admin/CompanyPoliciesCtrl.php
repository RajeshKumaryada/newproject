<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyPoliciesCtrl extends Controller
{
    public function viewCompanyPolicy()
    {
        return view('admin.company_policies.policies_company');
    }

    /**
     * Render Web Images
     */
    public function renderCompanyImage($folder, $img_id)
    {

        if (Storage::disk('public')->exists("{$folder}/{$img_id}")) {
            $headers = array(
                'Content-Disposition' => 'inline',
            );
            $img = Storage::download("public/{$folder}/{$img_id}", null, $headers);

            return $img;
        } else {
            return abort(404);
        }
    }
}
