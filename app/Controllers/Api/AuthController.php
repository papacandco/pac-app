<?php

namespace App\Controllers\Api;

use App\Controllers\Controller;
use Bow\Http\Request;

class AuthController extends Controller
{
    /**
     * Get all user
     *
     * @return mixed
     */
    public function __invoke(Request $request)
    {
        return $request->user();
    }
}
