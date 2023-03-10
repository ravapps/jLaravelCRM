<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\User;
use Efriandika\LaravelSettings\Facades\Settings;
use Illuminate\Support\Facades\App;
use Sentinel;
use Stripe\Util\Set;

class UserController extends Controller {
	protected $user;
	protected $non_read_meeages;
	protected $last_meeages;

	public function __construct() {
		$this->middleware( function ( $request, $next ) {
		    $settings = Settings::getAll();
		    view()->share('settings',$settings);
			if ( Sentinel::check() ) {
                $language = isset($settings['language'])?$settings['language']:'en';
                App::setLocale($language);
				$this->user = Sentinel::getUser();
				$user_data = User::find($this->user->id);
				view()->share( 'user_data', $user_data );
				$this->non_read_meeages = Email::where( 'to', $this->user->id )->where( 'read', '0' )->count();
				view()->share( 'non_read_meeages', $this->non_read_meeages );
				$this->last_meeages = Email::where( 'to', $this->user->id )->limit( 5 )->get();
				view()->share( 'last_meeages', $this->last_meeages );

				config(['settings.date_format' => Settings::get('date_format')]);
                config(['settings.time_format' => Settings::get('time_format')]);
                config(['settings.date_time_format' => Settings::get('date_format').' '.Settings::get('time_format')]);

				view()->share( 'jquery_date', Settings::get( 'jquery_date' ) );
				view()->share( 'jquery_date_time', Settings::get( 'jquery_date_time' ) );

			} else {
				Sentinel::logout( null, true );

				return redirect( 'signin' )->send();
			}

			return $next( $request );
		} );
	}
}
