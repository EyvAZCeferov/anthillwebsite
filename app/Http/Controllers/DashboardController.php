<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\Helper;
use App\Models\Products;
use App\Models\ContactUs;

class DashboardController extends Controller
{
    public function dashboard()
    {
        try {
            return view(
                'dashboard'
            );
        } catch (\Exception $e) {
            return $e->getMessage();
        } finally {
            Helper::dbdeactive();
        }
    }
}
