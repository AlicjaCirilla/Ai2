<?php

namespace App\Controller;

use App\Entity\Measurment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherUtil;
use Symfony\Component\HttpFoundation\Response;
final class WeatherApiController extends AbstractController
{
    public function __construct(private readonly WeatherUtil  $weatherUtil){}
    #[Route('/api/v1/weather', name: 'app_weather_api')]
    public function index(#[MapQueryParameter] string $city,
                          #[MapQueryParameter] string $country,
                          #[MapQueryParameter] string $format,
                          #[MapQueryParameter('twig')] bool $twig = false): Response
    {
        $measurements = $this->weatherUtil->getWeatherForCountryAndCity(strtoupper($country), $city);
        if ($format === 'csv'){
            if ($twig) {
                return $this->render('weather_api/index.csv.twig', [
                    'city' => $city,
                    'country' => $country,
                    'measurements' => $measurements,
                ]);
            }
            else {
                $words = "city, country, date, Celsius, Fahrenheit, atmospheric pressure, cloudiness, wind\n";
                $words .= implode("\n",
                    array_map(fn(Measurment $m) => sprintf(
                        '%s, %s, %s, %s, %s, %s, %s, %s',
                        $city,
                        $country,
                        $m->getDate()->format('Y-m-d'),
                        $m->getTemperature(),
                        $m->getFahrenheit(),
                        $m->getAtmosphericPressure(),
                        $m->getCloudiness(),
                        $m->getWind(),
                    ), $measurements));
                return new Response($words, 200, [
                    //'Content-Type' => 'text/csv'
                ]);
            }
        }
        elseif ($format === 'json'){
            if ($twig) {
                    return $this->render('weather_api/index.json.twig', [
                        'city' => $city,
                        'country' => $country,
                        'measurements' => $measurements,
                    ]);
            }
            else{
            return $this->json([
                'city' => $city,
                'country' => $country,
                'measurements' => array_map(fn(Measurment $m)=>[
                    'date' => $m->getDate()->format('Y-m-d'),
                    'Celsius' => $m->getTemperature(),
                    'Fahrenheit' =>$m->getFahrenheit(),
                    'Atmospheric Pressure'=>$m->getAtmosphericPressure(),
                    'Cloudiness'=>$m->getCloudiness(),
                    'Wind'=>$m->getWind()
                ], $measurements),
            ]);}
        }
        return new Response("wrong format", 404);
    }
}
