<?php

namespace App\Jobs;

use App\Models\City;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

use App\Services\OpenWeatherService;

class FetchCurrentWeather implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected OpenWeatherService $service;
    protected array $cities;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new OpenWeatherService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Job for fetching cities current weather data.');

        Redis::transaction(function ($redis) {
            foreach (City::all() as $city) {
                // Get data
                $response = $this->service->getCurrentWeatherByCityName($city->name);

                // Prepare format
                $weatherData = $this->service->destructCurrentWeatherData($response);
                
                // Set data as hash in redis
                $redis->hmset($city->name, $weatherData);
            }
        });
    }
}
