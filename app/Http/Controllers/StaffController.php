<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class StaffController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    /**
     * Show the tenant application dashboard.
     *
     *
     * @return Factory|View
     */
    public function index()
    {
        return view('tenant.staff');
    }
}
