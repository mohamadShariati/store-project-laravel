<?php

namespace App\Http\Controllers\Auth;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToProvider ($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $socialite_user= Socialite::driver($provider)->user();
            $user=User::where('email',$socialite_user->getEmail())->first();

            if(!$user)
            {
               $user= User::create([
                    'name'=>$socialite_user->getName(),
                    'provider_name'=>$provider,
                    'avatar'=>$socialite_user->getAvatar(),
                    'email'=>$socialite_user->getEmail(),
                    'password'=>Hash::make($socialite_user->getId()),
                    'email_verified_at'=>Carbon::now()
                ]);
            }

        } catch (\Exception $ex) {
            alert()->error($ex->getMessage().' مشکل در ورود  ')->persistent('حله');
            return redirect()->back();
        }

        auth()->login($user,$remember=true);
        alert()->success('با تشکر', 'ورود با موفیت انجام شد')->persistent('حله');

        return redirect()->route('home.index');


    }
}
