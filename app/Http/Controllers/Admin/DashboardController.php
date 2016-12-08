<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

/**
 * Class DashboardController.
 *
 * @author Phillip Madsen <contact@affordableprogrammer.com>
 */
class DashboardController extends Controller
{
    public function index()
    {
        return view('backend/layout/dashboard', compact('chartData'))->with('active', 'home');
    }
}
