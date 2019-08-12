<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\College;

class CollegesController extends Controller
{
    public function index() {
        return $this->response->array(College::all()->toArray());
    }
}
