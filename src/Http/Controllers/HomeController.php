<?php

namespace Bishopm\Blog\Http\Controllers;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    public function home()
    {
        return view('blog::home');
    }
}
