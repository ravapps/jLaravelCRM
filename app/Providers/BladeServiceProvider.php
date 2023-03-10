<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Efriandika\LaravelSettings\Facades\Settings;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Blade::directive('money', function ($money) {
          $val= Settings::get('currency');
          if($val == "USD") {
            $val="$ ";
          }
          if(Settings::get('currency_position') == "left") {

              return "<?php echo '".$val."'.{$money}; ?>";
          } else {

              return "<?php echo {$money} . '".$val."'; ?>";
          }

        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
