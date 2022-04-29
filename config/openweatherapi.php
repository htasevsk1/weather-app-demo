<?php

return [
    'api_key' => env('OPENWEATHER_API_KEY'),
    'base_url' => 'https://api.openweathermap.org/data/2.5', 
    'lang' => env('OPENWEATHER_API_LANG', 'en'),
];