<?php

namespace App\Http\Controllers;

use App\Models\ReportType;
use Illuminate\Http\Request;

class ReportTypeController extends Controller
{
    public function get() {
        $report_types = ReportType::get();
        return [ "data" => $report_types ];
    }
}
