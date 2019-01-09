<?php

namespace GorillaDash\LaravelWebsite\Commands;

use Eastwest\Json\Json;
use Exception;
use GorillaDash\LaravelWebsite\Exceptions\GorillaDashInvalidQueryException;
use GorillaDash\LaravelWebsite\Queries\QueryFactory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CacheWebsiteInfoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:website-info';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cached the website information';

    /**
     * Cache file
     * @var string
     */
    public static $path = '/cached/website.json';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle()
    {
        try {
            $client = QueryFactory::create('websiteInfo', []);
            if ($result = $client->get()) {
                Storage::put(self::$path, Json::encode($result));
                $this->comment('Cached the website information');
            }
        } catch (GorillaDashInvalidQueryException $ex) {
            $this->error($ex);
        } catch (Exception $ex) {
            $this->error($ex);
        }
    }
}
