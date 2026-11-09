<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
#[AsCommand(
    name: 'weather:location',
    description: 'Add a short description for your command',
)]
class WeatherLocationCommand{
    public function __construct(private readonly WeatherUtil $weatherUtil){}
    public function __invoke(
        SymfonyStyle $io,
        #[Argument('Location ID')] int $id,
    ): int {
        $location= $this->WeatherUtil->getWeatherForLocation($id);
        return [];
//        $io->note(sprintf('The value of $id is: %s', var_export($id, true)));
//
//        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
//
//        return Command::SUCCESS;
    }
}
