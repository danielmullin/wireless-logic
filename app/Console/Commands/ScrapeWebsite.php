<?php

namespace App\Console\Commands;

use RoachPHP\Roach;
use App\Spiders\WirelessLogicSpider;
use Illuminate\Console\Command;

class ScrapeWebsite extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ScrapeWebsite';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Roach scrape the page
        // @todo throw exceoption
        $items = Roach::collectSpider(WirelessLogicSpider::class);

        // Extract items
        $data = [];
        foreach ($items as $item) {
            $data[] = $item->all();
        }

        // Sorting on price
        usort($data, function ($item1, $item2) {
            return (int)str_replace('£', '', $item2['price']) <=> (int)str_replace('£', '', $item1['price']);
        });

        //displaying result if exist
        if ($data) {
            $this->line(json_encode($data, JSON_UNESCAPED_UNICODE));
        }
        else {
            'No items found.';
        }

        return 0;
    }
}
