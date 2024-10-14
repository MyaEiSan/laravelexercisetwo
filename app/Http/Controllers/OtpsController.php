<?php

namespace App\Http\Controllers;

use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpsController extends Controller
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }
    public function generate(){

        $userid = Auth::id();
        $getotp = $this->otpService->generateOtp($userid);

        return response()->json(["message" => "OTP generated successfully", "otp" => $getotp]);

    }

    public function verify(Request $request){
        $userid = $request->input('otpuser_id');
        $otp = $request->input('otpcode');
        $isvalidotp = $this->otpService->verifyotp($userid,$otp);

        if($isvalidotp){
            return response()->json(["message" => "OTP is valid"]);
        }else{
            return response()->json(["message"=>"OTP is invalid"],400);
        }
        
    }
}


