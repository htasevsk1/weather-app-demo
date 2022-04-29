<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

class OpenWeatherService
{

    private $apiKey = NULL;
    private $baseUrl = NULL;
    private const CURRENT_WEATHER = 'weather';

    /**
     * Constructor.
     *
     * @return  void
     */
    public function __construct()
    {
        $this->apiKey = Config::get('openweatherapi.api_key');
        $this->baseUrl = Config::get('openweatherapi.base_url');
    }

    private function prepareUrl(string $path)
    {
        return $this->baseUrl . '/' . $path;
    }

    private function getCurrentWeather(array $params)
    {
        $url = $this->prepareUrl(self::CURRENT_WEATHER);
        $response = Http::get($url, $params);

        if (!$response) {
            return null;
        }

        return $response;
    }

    public function getCurrentWeatherByCityName(string $city)
    {
        return $this->getCurrentWeather([
            'q' => $city,
            'appid' => $this->apiKey
        ]);
    }
}