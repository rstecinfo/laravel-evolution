<?php

namespace Luanrodrigues\LaravelEvolution\Facades;

use Illuminate\Support\Facades\Facade;

class EvolutionApi extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'evolution-api';
    }
}
