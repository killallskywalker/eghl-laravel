<?php

namespace Killallskywalker\Eghl\Tests;

use Killallskywalker\Eghl\EghlServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
  public function setUp(): void
  {
    parent::setUp();
  }

  protected function getPackageProviders($app)
  {
    return [
      EghlServiceProvider::class,
    ];
  }

  protected function getEnvironmentSetUp($app)
  {

  }
}