<?php namespace D3catalyst\Compress\Laravel4\ServiceProviders;

use Illuminate\Support\ServiceProvider;
use D3Catalyst\Compress\Compress as Compress;

class CompressServiceProvider extends ServiceProvider {
	
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind('compress', function(){
			return new Compress;
		});

		// Create required folders
		@mkdir(public_path('d3compress'), 0777, true);
		@mkdir(public_path('d3compress/full'), 0777, true);
		@mkdir(public_path('d3compress/min'), 0777, true);
	}
}