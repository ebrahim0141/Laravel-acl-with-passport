<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth, Validator;
use App\User;
use App\Http\Controllers\Helper\HelperController;

class AuthController extends Controller
{
    private $helping = "";
    

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function test(){
        // return response()->json($_SERVER);
        return $this->helping->invalidDeleteId('shishir');
    }

    public function login(Request $request){ 
        // if(! Auth::attempt(['email' => request('email')])){
        //     $responseData = $this->helping->invalidLogin("Incorrect email.");
        //     return response()->json($responseData); 
        // }

        // if(! Auth::attempt(['password' => request('password')])){
        //     $responseData = $this->helping->invalidLogin("Incorrect password.");
        //     return response()->json($responseData); 
        // }

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            
            $user = Auth::user(); 

            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user['api_token'] = $success['token'];
            $user['token_type'] = "Bearer";

            $responseData = $this->helping->responseProcess(0, 200, "Your are logged in", [
                'users' => $user, 
            ]);

            return response()->json($responseData); 
        } 
        else{ 
            $responseData = $this->helping->invalidLogin("You have entered an incorrect email No/Password combination.");
            return response()->json($responseData); 
        } 
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        
        if($validator->fails()){
            $errors = $validator->errors();
            $errorMsg = "";
            
            foreach ($errors->all() as $msg) {
                $errorMsg .= $msg;
            }

            $responseData = $this->helping->validatingErrors($errorMsg);
            return response()->json($responseData);
        }
       
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->save();

        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
            
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $user['api_token'] = $success['token'];
            $user['token_type'] = "Bearer";

            $responseData = $this->helping->loggedIn(['users' => $user]);
            return response()->json($responseData); 
        } 
        else{ 
            $responseData = $this->helping->serverError();
            return response()->json($responseData); 
        } 
    }
}
