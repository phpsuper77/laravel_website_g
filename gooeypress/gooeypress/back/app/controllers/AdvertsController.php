<?php

class AdvertsController extends \BaseController {

    public function dashboard(){
        $me = Auth::user();

        return View::make('adverts/dashboard', [
            'me' => $me,
        ]);
    }

    /**
     * Choose advert type: theme | product
     */
    public function choose(){
        $me = Auth::user();
        $units = intval(Input::get('units'));
        $action = Input::get('action');

        if($units > 0){
            Session::put('advert.units', $units);
        }
        $units = Session::get('advert.units', Config::get('adverts.default_units'));

        if('product' == $action){ return Redirect::to('adverts/create/product'); }
        else if('theme' == $action){ return Redirect::to('adverts/create/theme'); }

        return View::make('adverts/choose-type', [
            'me' => $me,
            'units' => $units,
        ]);
    }

    /**
     * Order form to place an advert
     */
    public function create($type){
        $me = Auth::user();
        $template = 'theme' == $type ? 'adverts/order-theme' : 'adverts/order-product';

        $units = Session::get('advert.units', Config::get('adverts.default_units'));

        $url = trim(Input::get('theme_url'));
        if($url != ''){
            $base = url('theme');
            $prefix = substr($url, 0, strlen($base));

            if($prefix != $base){
                $hash = '';
            }else{
                $hash = substr($url, strlen($base));
                list($t, $hash, $title) = explode('/', $hash);
            }

            Session::put('advert.theme_hash', $hash);
            $hash = Session::get('advert.theme_hash');
        }
        if(Input::get('remove') == Session::get('advert.theme_hash')){
            Session::put('advert.theme_hash', '');
        }
        $hash = Session::get('advert.theme_hash');

        $theme = Theme::with('vendor')->where('hash', '=', $hash)->first();

        return View::make($template, [
            'me' => $me,
            'units' => $units,
            'theme' => $theme,
        ]);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
    public function store(){
        $me = Auth::user();

        $hash  = Input::get('theme_hash');
        $units = intval(Input::get('units'));
        $type = Input::get('type');

        $theme = Theme::with('vendor')->where('hash', '=', $hash)->first();

        $advert = new Advert();

        $advert->type = $type; // TODO: validate
        $advert->owner_id = $me->id;

        $advert->impression_budget = $units * Config::get('adverts.impressions_per_unit');
        $advert->price = Config::get('adverts.price_per_unit');
        $advert->qty = $units;
        $advert->gross = $units * $advert->price;
        $advert->payed_amount = 0;

        $advert->impressions = 0;
        $advert->clicks = 0;
        $advert->status = 'placed';

        switch($type){
        case 'theme':
            $advert->theme_id = $theme->id;
            break;
        case 'product':
            // TODO: function to be added
            $advert->name = '';
            $advert->advert_image_url = '';
            break;
        default:

        }

        $advert->save();

        return Redirect::to('adverts/show/'. $advert->id);
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function orders()
	{
        $me = Auth::user();
        $adverts = Advert::where('owner_id', '=', $me->id)->paginate(20);

        return View::make('adverts.orders', [
            'me' => $me,
            'adverts' => $adverts,
        ]);
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $me = Auth::user();
        $advert = Advert::findOrFail($id);

        $theme = null;
        if($advert->type == 'theme'){
            $theme = Theme::find($advert->theme_id);
        }

        $template = 'theme' == $advert->type ? 'adverts/show-theme' : 'adverts/show-product';

        return View::make($template, [
            'me' => $me,
            'advert' => $advert,
            'theme' => $theme,
        ]);
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public function paypalIPN(){
        $request = Request::instance();
        $content = $request->getContent();

        $fields = [];

        foreach(explode('&', $content) as $item){
            $parts = explode('=', $item);
            if(count($parts) == 2){
                $fields[$parts[0]] = urldecode($parts[1]);
            }
        }

        if(function_exists('get_magic_quotes_gpc')) {
            $magic_quotes = true;
        }else{
            $magic_quotes = false;
        }

        $parts = ['cmd=_notify-validate'];
        foreach($fields as $k => $v){
            if(function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() == 1) {
                $v = urlencode(stripslashes($v));
            }else{
                $v = urlencode($v);
            }

            $parts[] = "$k=$v";
        }
        $req = join('&', $parts);

        $gateway = Config::get('adverts.gateway');
        $debug = Config::get('adverts.debug');

        $ch = curl_init($gateway);
        if($ch == FALSE){
            return App::error('500');
        }

        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));

        curl_setopt($ch, CURLOPT_CAINFO, storage_path() . "/cacert.pem");

        if($debug == true) {
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLINFO_HEADER_OUT, 1);
        }

        $res = curl_exec($ch);
        if (curl_errno($ch) != 0) // cURL error
        {
            if($debug == true) {
                Log::error(date('[Y-m-d H:i e] '). "Can't connect to PayPal to validate IPN message: " . curl_error($ch) );
            }
            curl_close($ch);
            exit;
        }
        else{
            if($debug == true){
                Log::error(date('[Y-m-d H:i e] '). "HTTP request of validation request:". curl_getinfo($ch, CURLINFO_HEADER_OUT) ." for IPN payload: $req");
                Log::error(date('[Y-m-d H:i e] '). "HTTP response of validation request: $res");

                list($headers, $res) = explode("\r\n\r\n", $res, 2);
            }
            curl_close($ch);
        }

        if (strcmp ($res, "VERIFIED") == 0) {

            // check whether the payment_status is Completed
            if($fields['payment_status'] != 'Completed'){
                exit;
            }
            // check that txn_id has not been previously processed
            $advert = Advert::where('txn_id', '=', $fields['txn_id'])->first();

            if($advert != NULL){
                exit;
            }

            $advert_id = intval($fields['custom']);
            $advert = Advert::findOrFail($advert_id);

            // check that receiver_email is your PayPal email
            if($fields['receiver_email'] != Config::get('adverts.paypalID')){
                exit;
            }
            // check that payment_amount/payment_currency are correct
            if($fields['mc_gross'] < $advert->gross || $fields['mc_currency'] != 'USD'){
                exit;
            }

            // process payment and mark item as paid.
            $advert->payed_amount = $fields['mc_gross'];
            $advert->status = 'payed';
            $advert->txn_id = $fields['txn_id'];
            $advert->save();
        }
    }


}
