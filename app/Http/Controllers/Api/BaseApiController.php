<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

abstract class BaseApiController extends Controller
{
    use ApiResponse;

    /**
     * BaseApiController constructor.
     */
    public function __construct()
    {
        // Common initialization for all API controllers
    }
} 