<?php


namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Carbon\Carbon;
use Image;


class UserController extends Controller
{


    public $successStatus = 200;


    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request){

        $validator = Validator::make($request->all(), [
            'email'   => 'required',
            'password'   => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['error_code'=> 1,'message'=>$validator->errors()], 401);   
        }
        $userdata = array(
            'email' => request('email'),
            'password' => request('password')
        );

          // doing login.
        if (Auth::attempt($userdata)) {
            if(Auth::user()->email == request('email') ){
                if(Auth::user()->record_status == false ) {
                    return response()->json(['error_code'=>1,'message'=>'Users Deactivated,please contact administrator.'], 401);
                }
            }
        }
        if(Auth::attempt(['email' => request('email'), 'password' => request('password'),'record_status'=>true]))
        {
            $user = Auth::user();
            $success =  $user->createToken('MyApp')->accessToken;
            return response()->json(['token'=>$success,'user'=>$user, 'message'=>'Login Successfull'], $this->successStatus);
        }
        else{
            return response()->json(['error_code'=>1,'message'=>'Unauthorised'], 401);
        }
    }


    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required|min:11|numeric|unique:users,phone',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'age' => 'required|min:2|numeric',
            'sex' => 'required',
            
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = new User;
        $user->record_status = true;
        if($request->hasFile('image')) {
            $file = $request->image;
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path('profile'), $filename);
            $user->image = "profile/".$filename;
           
        }


       
        if($user->fill($input)->save()){
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            // $success['name'] =  $user->name;
            $success['data'] = $user;
            return response()->json($success, 201);
        }
  
    }

    /**
     * Update api
     *
     * @return \Illuminate\Http\Response
     */

    public function updateprofile(Request $request,$id){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'required',
            'c_password' => 'required|same:password',
            'phone' => 'required|min:11|numeric|unique:users,phone',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'age' => 'required|numeric',
            'sex' => 'required',
        ]);


        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()], 401);            
        }


        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user =  User::findOrFail($id);
        $user->record_status = true;
        
       
        if($request->hasFile('image')) {
           
            $file = $request->image;
            $timestamp = str_replace([' ', ':'], '-', Carbon::now()->toDateTimeString());
            $filename = $timestamp. '-' .$file->getClientOriginalName();
            $file->move(public_path('/profile'), $filename);
            $user->image = "profile/".$filename;
           
        }
        $user->fill($input)->save();
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['data'] = $user;
        return response()->json($success, 201);
    }
    
    public function logoutApi()
    { 
        if (Auth::check()) {
           Auth::user()->AauthAcessToken()->delete();
           return response()->json(['success'=>'Logout Success'], $this->successStatus);
        }
    }
    
    
    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function details()
    {
        $user = Auth::user();
        return response()->json(['success' => $user], $this->successStatus);
    }
    public function getdata(){
        $user = User::all();
        return response()->json(['success' => $user], $this->successStatus);
    }
}