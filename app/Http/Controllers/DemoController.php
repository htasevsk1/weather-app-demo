<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Redis;

class DemoController extends Controller
{
    public function index(){
        $keys = Redis::keys('cities.*');

        $cities = [];

        foreach($keys as $key) {
            $cities[str_replace('cities.', '', $key)] = Redis::hgetall($key);
        }

        return view('demo', ['cities' => $cities]);
    }
}
