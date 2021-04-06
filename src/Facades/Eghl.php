<?php

namespace Killallskywalker\Eghl\Facades;

use Illuminate\Support\Facades\Facade;

class Eghl extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'eghl';
    }
}