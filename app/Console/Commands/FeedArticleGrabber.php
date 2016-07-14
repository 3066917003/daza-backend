<?php

namespace App\Console\Commands;

use App\Models\Topic;
use App\Models\Article;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class FeedArticleGrabber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'feed_article_grabber';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Nothing';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $topics = Topic::orderBy('id', 'ASC')->get();

        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
