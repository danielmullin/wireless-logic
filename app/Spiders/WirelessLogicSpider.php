<?php

namespace App\Spiders;

use Generator;
use RoachPHP\Http\Response;
use RoachPHP\Spider\BasicSpider;
use RoachPHP\Spider\ParseResult;


class WirelessLogicSpider extends BasicSpider
{
    
    /**
     * @todo extract to configuration.
     * @var array
     */
    public array $startUrls = [
        'https://wltest.dns-systems.net/'
    ];

    /**
     * @return Generator<ParseResult>
     */
    public function parse(Response $response): Generator
    {
        
        $titles = $response->filter(config('wirelessLogic.filters.title'));
        $descriptions = $response->filter(config('wirelessLogic.filters.description'));
        $prices = $response->filter(config('wirelessLogic.filters.price'));
        $discounts = $response->filter(config('wirelessLogic.filters.discount'));

        $count = $titles->count();

        for ($i = 0; $i < $count; $i++) {

            yield $this->item([
                'option title' => $titles->getNode($i)->textContent,
                'description' => $descriptions->getNode($i)->textContent,
                'price' => $prices->getNode($i)->textContent,
                'discount' => empty($discounts->getNode($i - 3)) ? '' : $discounts->getNode($i - 3)->textContent,
            ]);
        }
    }
}
