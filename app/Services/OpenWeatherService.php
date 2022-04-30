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

        return $response->json();
    }

    public function getCurrentWeatherByCityName(string $city)
    {
        return $this->getCurrentWeather([
            'q' => $city,
            'units' => 'metric',
            'appid' => $this->apiKey
        ]);
    }

    public function getCurrentWeatherById(int $id)
    {
        return $this->getCurrentWeather([
            'id' => $id,
            'units' => 'metric',
            'appid' => $this->apiKey
        ]);
    }

    public function destructCurrentWeatherData(array $weatherData)
    {
        if ($weatherData && $weatherData['cod'] == 200) {
            return [
                'temp' => $weatherData['main']['temp'],
                'humidity' => $weatherData['main']['humidity'],
                'description' => $weatherData['weather'][0]['main']
            ];
        }

        return [
            'temp' => null,
            'humidity' => null,
            'description' =>  null,
        ];
    }
}