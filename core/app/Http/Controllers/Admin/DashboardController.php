<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Language;
use App\Quote;
use App\ProductOrder;
use App\ServiceRequest;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $data['quotes'] = Quote::orderBy('id', 'DESC')->limit(10)->get();
        $data['porders'] = ProductOrder::orderBy('id', 'DESC')->limit(10)->get();
        $data['default'] = Language::where('is_default', 1)->first();
        $data['pending_requests'] = ServiceRequest::where('status', 'Pending')->count();
        return view('admin.dashboard', $data);
    }
}
