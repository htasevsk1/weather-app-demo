# OpenWeather API implementation DEMO
This is DEMO application that utilizes [OpenWeather API](https://openweathermap.org/).

This is a basic [Laravel app](https://laravel.com/) build using [Laravel Sail](https://laravel.com/docs/9.x/sail), with ```mysql```, ```redis``` and ```devcontainer``` containers.

## Local testing
1. Inside the project's root directory, run ```./vendor/bin sail up -d```. This will build the docker containers.
2. Go inside the devcontainer
3. ```cp .env.example .env``` and set your env variables. **NOTE**: You have to have a valid API key for the [OpenWeather API](https://openweathermap.org/). Open an account on their website and get your API key.
4. Run ```php artisan key:generate```
5. Run the migrations ```php artisan migrate:fresh --seed```
6. Open a new CLI tab in your editor and inside your devcontainer run ```php schedule:work ```, in order to get the scheduler up and running.
7. Go to [localhost](http://localhost/) inside your browser to see the data.
8. To run tests, run ```php artisan test```, or run ```php artisan test --filter FetchCurrentWeatherTest``` to test the of current weather data from [OpenWeather API](https://openweathermap.org/). 

## Notable components of the application
### OpenWeatherService 
This is a custom service class made to easily interact with [OpenWeather API](https://openweathermap.org/) inside the application.

### FetchCityCurrentWeather 
This a custom command that can be used to fetch current weather data for a specified city.

**Example:**
```bash
php artiasan currentWeather:fetch London
```

### FetchCurrentWeather
This is a custom job that is scheduled to fetch current weather data for the all cities from our database on an hourly schedule. It stores the current weather data for each city inside a [Redis hash](https://redis.io/docs/manual/data-types/#hashes).