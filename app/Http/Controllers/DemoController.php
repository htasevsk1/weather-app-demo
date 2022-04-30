<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class DemoController extends Controller
{
    public function index(){
        $cities = [];

        foreach(City::all() as $city) {
            $cities[$city->name] = Redis::hgetall($city->name);
        }

        return view('demo', ['cities' => $cities]);
    }
}
