<?php

class AccountController extends BaseController {

	public function showLoginForm()
	{
		return View::make('account.login');
	}
    public function doLogin()
    {
        extract( Input::only('username', 'password') );
        if (Auth::attempt(array('username' => $username, 'password' => $password)))
        {
            $me = Auth::user();

            if($me->isAdmin()){
                return Redirect::intended('adm/theme/list');
            }else{
                return Redirect::intended('themes');
            }
        }
    }

    public function profile(){
        $me = Auth::user();

        return View::make('account.profile', [
            'me' => $me,
        ]);
    }
    public function doProfile(){
        $me = Auth::user();

        $username = Input::get('username');
        $email = Input::get('email');

        if(User::where('username', '=', $username)->first()->id != $me->id){
            Session::flash('error', "Username ($username) is already taken. Please choose another one");
            return Redirect::to('/account/profile');
        }
        if(User::where('email', '=', $email)->first()->email != $me->email){
            Session::flash('error', "Email ($email) is already taken. Please choose another one");
            return Redirect::to('/account/profile');
        }

        $user = User::find($me->id);
        $user->fill(Input::only(['bio', 'username', 'website', 'location', 'first_name', 'last_name', 'email']));
        $user->save();

        return Redirect::to('/account/profile');
    }

    public function changePassword(){
        $me = Auth::user();

        return View::make('account.change-password', [ 'me' => $me ]);
    }
    public function doChangePassword(){
        $me = Auth::user();

        extract(Input::only('password', 'new_pass', 'pass_confirm'));

        $valid = Auth::validate(['email' => $me->email, 'password' => $password]);
        if($valid && $new_pass == $pass_confirm){
            $me->password = Hash::make($new_pass);
            $me->save();
            return Redirect::back()->with('message', 'Password changed successfully');
        }
    }
    public function emailPreference(){
        $me = Auth::user();
        $pref = $me->email_preference;

        return View::make('account.email-preference', [
            'me' => $me,
            'pref' => $pref,
        ]);
    }
    public function doEmailPreference(){
        $me = Auth::user();
        $pref = $me->email_preference;

        $new_pref = Input::only('updates', 'products', 'free_themes', 'recommendations', 'blog', 'give_aways');
        $me->email_preference = $new_pref;
        $me->save();

        return Redirect::back()->with('message', 'Email preference changed successfully');
    }

    public function savedThemes(){
        $me = Auth::user();

        $themes = $me->savedThemes()->paginate(10);

        return View::make('account.saved-themes', [
            'me' => $me,
            'themes' => $themes,
        ]);
    }

    public function activityStream(){
        $me = Auth::user();
        $activities = Activity::with('theme.vendor')->where('owner_id', '=', $me->id)->orderBy('created_at', 'desc')->paginate(10);

        return View::make('account.activity-stream', [
            'me' => $me,
            'activities' => $activities,
        ]);
    }

    public function encryptString()
    {
        $string = Input::get('string');
        $crypted = Hash::make($string);

        echo $crypted;
    }
    public function logout(){
        Auth::logout();

        return Redirect::to('account/login');
    }

	public function showSignupForm(){
		return View::make('account.signup');
	}

    public function doSignup(){
        $response = Redirect::to('account/login');
        try{
            $ud = Input::only('username', 'nicename', 'email');
            $ud['role'] = 'user';
            $u = User::create($ud);
            $u->password = Hash::make(Input::get('password'));
            $u->save();
        }catch(\Illuminate\Database\QueryException $e){
            switch($e->getCode()){
            case '23000':
                $response = Redirect::to('account/signup?err=duplicate');
                break;
            default:
            }
        }
        return $response;
    }
}
