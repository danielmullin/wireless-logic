<?php

namespace Tests\Unit;

use App\Console\Commands\ScrapeWebsite;
use App\Spiders\WirelessLogicSpider;
use PHPUnit\Framework\TestCase;
use RoachPHP\Roach;

class SpiderCommandTest extends TestCase
{

    /**
     * returns void
     */
    protected function setUp(): void
    {
        $this->runner = Roach::fake();
    }
    
    /**
     * returns void
     */
    protected function tearDown(): void
    {
        Roach::restore();
    }

    /**
     * returns void
     */
    public function testCorrectSpiderRunGetsStarted(): void
    {
        
        $command = new ScrapeWebsite();
        $command->handle();

        $this->runner->assertRunWasStarted(WirelessLogicSpider::class);
    }
}
