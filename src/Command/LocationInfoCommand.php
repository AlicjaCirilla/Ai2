<?php

namespace App\Command;

use App\Repository\LocationRepository;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'location:info',
    description: 'Add a short description for your command',
)]
class LocationInfoCommand{
    public function __construct(
        private readonly LocationRepository $locationRepository,
        private readonly WeatherUtil  $weatherUtil,
    ) {
    }
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Two letter country code')] string $country,
        #[Argument('Name of the city')] string $city,
    ): int {
        $location= $this->weatherUtil->getWeatherForCountryAndCity(strtoupper($country), $city);
        $io->writeln(sprintf('Location: %s in %s', $city, $country));
        $io->table(['Date', 'Temperature'], array_map(fn($m) => [
            $m->getDate()->format('Y-m-d'),
            $m->getTemperature(),
        ], $location));
//        $io->table(['Date', 'Temperature'], array_map(fn($m) => [
//            $m->getDate()->format('Y-m-d'),
//            $m->getTemperature(),
//        ], $location));
//        $io->note(sprintf('The value of $country is: %s', var_export($country, true)));
//        $io->note(sprintf('The value of $city is: %s', var_export($city, true)));
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return Command::SUCCESS;
    }
}
