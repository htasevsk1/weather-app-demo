<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\OpenWeatherService;

class FetchCurrentWeatherTest extends TestCase
{
    protected OpenWeatherService $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function setUp():void {
        parent::setUp();
        $this->service = new OpenWeatherService();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_fetch_current_weather()
    {
        $response = $this->service->getCurrentWeatherById(785842);

        $this->assertSame($response['name'], 'Skopje');
    }
}
