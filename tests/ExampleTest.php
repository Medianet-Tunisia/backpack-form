<?php

namespace MedianetDev\BackpackForm\Tests;

use MedianetDev\BackpackForm\AddonServiceProvider;
use Orchestra\Testbench\TestCase;

class ExampleTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [AddonServiceProvider::class];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
