<?php

namespace App\Jobs;

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

    protected array $cities;
    protected OpenWeatherService $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->cities = ['Skopje', 'Tetovo', 'Ohrid'];
        $this->service = new OpenWeatherService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('job fetch data');

        Redis::transaction(function ($redis) {
            foreach ($this->cities as $city) {
                $weatherData = $this->service->getCurrentWeatherByCityName($city);
                $redis->set($city, $weatherData);
            }
        });
    }
}
