<?php 

namespace App\Services;

use App\Jobs\OtpMailJob;
use App\Models\Otp;
use App\Models\User;
use App\Notifications\OtpEmailNotify;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OtpService{

    public function generateOtp($userid){

        $randomotp = rand(100000,999999);
        $expireset = Carbon::now()->addMinute(1);

        $user = Auth::user();

        Otp::create([
            'user_id' => $userid,
            'otp' => $randomotp, 
            'expires_at' => $expireset
        ]);

        $data = [
            'otp' => $randomotp
        ];

        Notification::send($user,new OtpEmailNotify($data)); 

        // dispatch(new OtpMailJob($user->email,$randomotp));

        // Send OTP via to email 

        return $randomotp;
    }

    public function verifyotp($userid, $otp){

        $checkotp = Otp::where('user_id', $userid) 
                    ->where('otp', $otp) 
                    ->where('expires_at','>',\Carbon\Carbon::now())->first();
                    dd($checkotp);

        if($checkotp){

            // OTP valid 

            $checkotp->delete(); // Delete OTP after verification 

            return true;
        }else{
            // OTP Invalid 

            return false;
        }
    }

}

?>