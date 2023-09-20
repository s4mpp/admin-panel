<?php

namespace S4mpp\AdminPanel\Commands;


use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install admin panel';

    /**
     * Execute the console command.
     */
    public function handle()
    {
		$this->_publishAdminCss();

		$this->_publishElementCss();
        
        return 0;
    }

	private function _publishAdminCss()
	{
		$admin_assets = Artisan::call('vendor:publish --tag=admin-assets --force');

		if($admin_assets == 0)
		{
			$this->info('Admin CSS published');
		}
	}

	private function _publishElementCss()
	{
		$element_assets = Artisan::call('vendor:publish --tag=element-assets --force');

		if($element_assets == 0)
		{
			$this->info('Element CSS published');
		}
	}
}
