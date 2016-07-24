<?php

namespace App\Console\Commands;

use App\Models\Topic;
use App\Models\Article;

use DateTime;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\ClientException;
use Carbon\Carbon;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;

class AtomArticleGrabber extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'grabber:atom';

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
        $lists = Topic::orderBy('id', 'desc')->where('source_format', 'atom+xml')->get();

        $client = new Client();

        $requests = function ($lists) {
            foreach ($lists as $key => $topic) {
                $source_link = $topic->source_link;
                $this->info($source_link);
                yield new Request('GET', $source_link);
            }
        };

        $pool = new Pool($client, $requests($lists), [
            'concurrency' => 10,
            'fulfilled' => function ($response, $index) use ($lists) {
                // this is delivered each successful response
                $body = mb_convert_encoding($response->getBody()->getContents(), "UTF-8");

                $xml = simplexml_load_string( $body );

                $topic = $lists[$index];

                $data = [
                    'user_id'  => $topic->user_id,
                    'topic_id' => $topic->id,
                ];

                // print_r($lists[$index]->toArray());
                // print_r($xml);
                foreach ($xml->entry as $key => $value) {
                    // var_dump($value);
                    var_dump(new DateTime($value->published));
                    // var_dump(Carbon::createFromFormat(DateTime::ATOM . 'Z', $value->published));

                    $article = Article::firstOrCreate(array_merge($data, ['guid' => $value->id]));

                    $article->update([
                        'link'          => $value->link->attributes()->href,
                        'title'         => $value->title,
                        'summary'       => $value->summary,
                        'published_at'  => new DateTime($value->published),
                    ]);
                }
            },
            'rejected' => function ($reason, $index) {
                // this is delivered each failed request
                $this->error("rejected reason: " . $reason );
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
