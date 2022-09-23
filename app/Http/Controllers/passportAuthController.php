<?php

namespace App\Http\Controllers;

use App\Models\admin\Admin;
use App\Models\User;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class passportAuthController extends Controller
{
    use GeneralTrait;
    public function userDashboard()
    {
        $users = User::all();
        $success =  $users;
    return $this->returnData('users',$success,'all users');
       // return response()->json($success, 200);
    }

    public function adminDashboard()
    {
        $users = Admin::all();
        $success =  $users;
        return $this->returnData('admins',$success,'all admins');

       // return response()->json($success, 200);
    }
    //
    /**
     * handle user registration request
     */
    public function adminregister(Request $request)
    {
        try {


            $input = $request->only(['name', 'email', 'password']);
            $validate_data = [
                'name' => 'required',
                'email' => 'required|email|unique:admins',
                'password' => 'required|min:8',
            ];
            $validator = Validator::make($input, $validate_data);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $credentials = $request->only(['name', 'email', 'password']);
            if (auth()->guard('admin')->attempt($credentials)) {

                config(['auth.guards.api.provider' => 'admin']);

                $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
                $success = $admin;
                $success['token'] = $admin->createToken('MyApp', ['admin'])->accessToken;
                return $this->returnData('admin', $success);
                // return response()->json($success, 200);
            } else {
                return $this->returnError('E990999', 'the register is fucked up');
//            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
//            return $this->returnSuccessMessage('the registertion is done');
                //}
//        if (\auth()->attempt($credentials)) {
//            $token = auth()->user()->createToken('passport_token')->accessToken;
//            $user = \auth()->user();
//            $user->api_token = $token;
//
//
///// return token
//            return $this->returnData('user', $user);
//        }
//            else
//                return $this->returnError('E0009', 'The login information is incorrect');
            }
        }
    catch
        (\Exception $e){

        return $this->returnError($e->getLine(), $e->getMessage());

    }
    }
    /////////////////////////////////////////////////
    public function adminlogin(Request $request)
    {
        try {


            $input = $request->only(['name', 'email', 'password']);
            $validate_data = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ];
            $validator = Validator::make($input, $validate_data);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $credentials = $request->only(['name', 'email', 'password']);
            if (auth()->guard('admin')->attempt($credentials)) {

                config(['auth.guards.api.provider' => 'admin']);

                $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
                $success = $admin;
                $success['token'] = $admin->createToken('MyApp', ['admin'])->accessToken;
                return $this->returnData('admin', $success);
                // return response()->json($success, 200);
            } else {
                return $this->returnError('E990999', 'Email and Password are Wrong.');
//            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
//            return $this->returnSuccessMessage('the registertion is done');
                //}
//        if (\auth()->attempt($credentials)) {
//            $token = auth()->user()->createToken('passport_token')->accessToken;
//            $user = \auth()->user();
//            $user->api_token = $token;
//
//
///// return token
//            return $this->returnData('user', $user);
//        }
//            else
//                return $this->returnError('E0009', 'The login information is incorrect');
            }
        }
        catch
        (\Exception $e){

            return $this->returnError($e->getLine(), $e->getMessage());

        }
    }
    //////////////////////////////////////////////////
     public function userlogout(Request $request){
         try {

//             $user = User::select('users.*')->find(3);
return $request->user()->id;//$user->token;
            // $token = auth()->user()->token();
         }
     catch
         (\Exception $e){

             return $this->returnError($e->getLine(), $e->getMessage());

         }
        return auth('user')->check();//$token;
     }
    ////////////////////////////////////////////////
    public function userregister(Request $request)
    {
        try {


            $input = $request->only(['name', 'email', 'password']);
            $validate_data = [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:8',
            ];
            $validator = Validator::make($input, $validate_data);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            $credentials = $request->only(['name', 'email', 'password']);
            if (auth()->guard('user')->attempt($credentials)) {

                config(['auth.guards.api.provider' => 'user']);

                $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
                $success = $user;
                $success['token'] = $user->createToken('Personal Access Token', ['user'])->accessToken;
                return $this->returnData('user', $success);
                // return response()->json($success, 200);
            } else {
                return $this->returnError('E990999', 'the register is fucked up');
//            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
//            return $this->returnSuccessMessage('the registertion is done');
                //}
//        if (\auth()->attempt($credentials)) {
//            $token = auth()->user()->createToken('passport_token')->accessToken;
//            $user = \auth()->user();
//            $user->api_token = $token;
//
//
///// return token
//            return $this->returnData('user', $user);
//        }
//            else
//                return $this->returnError('E0009', 'The login information is incorrect');
            }
        }
    catch
        (\Exception $e){

        return $this->returnError($e->getLine(), $e->getMessage());

    }
    }
    ////////////////////////////////////////////////////
    public function userlogin(Request $request)
    {
        try {


            $input = $request->only(['name', 'email', 'password']);
            $validate_data = [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8',
            ];
            $validator = Validator::make($input, $validate_data);

            if ($validator->fails()) {
                $code = $this->returnCodeAccordingToInput($validator);
                return $this->returnValidationError($code, $validator);
            }

            $credentials = $request->only(['name', 'email', 'password']);
            if (auth()->guard('user')->attempt($credentials)) {

                config(['auth.guards.api.provider' => 'user']);

                $user = User::select('users.*')->find(auth()->guard('user')->user()->id);
                $success = $user;
                $success['token'] = $user->createToken('MyApp', ['user'])->accessToken;
                return $this->returnData('user', $success);
                // return response()->json($success, 200);
            } else {
                return $this->returnError('E990999', 'the register is fucked up');
//            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
//            return $this->returnSuccessMessage('the registertion is done');
                //}
//        if (\auth()->attempt($credentials)) {
//            $token = auth()->user()->createToken('passport_token')->accessToken;
//            $user = \auth()->user();
//            $user->api_token = $token;
//
//
///// return token
//            return $this->returnData('user', $user);
//        }
//            else
//                return $this->returnError('E0009', 'The login information is incorrect');
            }
        }
    catch
        (\Exception $e){

        return $this->returnError($e->getLine(), $e->getMessage());

    }
    }
    /////////////////////////////////////////////
    /**
     * login user to our application
     */




//    public function adminLogin(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'email' => 'required|email',
//            'password' => 'required',
//        ]);
//
//        if($validator->fails()){
//            return response()->json(['error' => $validator->errors()->all()]);
//        }
//
//        if(auth()->guard('admin')->attempt(['email' => request('email'), 'password' => request('password')])){
//
//            config(['auth.guards.api.provider' => 'admin']);
//
//            $admin = Admin::select('admins.*')->find(auth()->guard('admin')->user()->id);
//            $success =  $admin;
//            $success['token'] =  $admin->createToken('MyApp',['admin'])->accessToken;
//
//            return response()->json($success, 200);
//        }else{
//            return response()->json(['error' => ['Email and Password are Wrong.']], 200);
//        }
//    }//    public function authenticatedUserDetails(){
//        //returns details
//    return $this->returnData('authenticated-user' ,auth()->user());
////        return response()->json(['authenticated-user' => auth()->user()], 200);
//    }
}
