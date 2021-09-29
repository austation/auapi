<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwaggerScan extends Command
{
	protected $signature = 'swg:scan';
	protected $description = "Generate Swagger JSON";
	public function __construct() {
		parent::__construct();
	}
    public function handle() {
        $path = dirname(dirname(__DIR__));
        $outputPath = dirname(dirname(dirname(__DIR__))) . DIRECTORY_SEPARATOR . 'public/swagger/v3/swagger.json';
        $this->info('Scanning ' . $path);
        $openApi = \OpenApi\scan($path);
        header('Content-Type: application/json');
        file_put_contents($outputPath, $openApi->toJson());
        $this->info('Output ' . $outputPath);
    }
}
