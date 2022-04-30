<?php

namespace App\Console\Commands;

use App\Services\OpenWeatherService;
use Illuminate\Console\Command;

class FetchCityCurrentWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currentWeather:fetch {city}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected OpenWeatherService $service;

    public function __construct(OpenWeatherService $service)
    {
        parent::__construct();

        $this->service = $service;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $city = $this->argument('city');

        $response = $this->service->getCurrentWeatherByCityName($city);

        $this->output->success(sprintf("The following data for city %s was retrieved from the API: \n %s", $city, json_encode($response)));

        return true;
    }
}
