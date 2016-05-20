<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Exceptions\JWTException;
use JWTAuth;
use App\User;
use App\Models\Admin;
use App\Models\State;
use DateTime;

class UserController extends Controller
{

    public function __construct()
    {
        // Apply the jwt.auth middleware to all methods in this controller
        // except for the authenticate method. We don't want to prevent
        // the user from retrieving their token if they don't already have it
       $this->middleware('jwt.auth', ['except' => ['index', 'authenticate', 'postRegister', 'forgetPassword', 'editUser']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (JWTAuth::invalidate(JWTAuth::getToken())) {

            $users = User::all();

            $users_modified = array();
            $user_modified;
            foreach ($users  as $user){

                $user_modified = $user;
                $user = User::find($user->id);
                $user_modified->image_url = $user->image_url;
                $users_modified[] = $user_modified;
            }
            return $users_modified;
        } else {
            return response()->json(array('status', 1));
        }     
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            // verify the credentials and create a token for the user
            if (! $token = JWTAuth::attempt($credentials)) {

                return response()->json(['error' => 1], 401);
            }
        } catch (JWTException $e) {
            // something went wrong
            return response()->json(['error' => 0], 500);
        }

        $user = User::where('email', $request->email)->first();
        $state = State::where('user_id', $user->user_id)->first();
        // if no errors are encountered we can return a JWT
        return response()->json(compact(['token', 'user', 'state']));
    }

    public function logout()
    {
        if (JWTAuth::invalidate(JWTAuth::getToken())) {
            return response()->json(array('status', 0));
        } else {
            return response()->json(array('status', 1));
        }
    }

    public function postRegister(Request $request) {

        if ($request->isMethod('post')) {

            if (User::where('email', $request->input('email'))->count() > 0)
                return response()->json(array('error' => 'Email already exists.'));

            $user = new User;
            $state = new State;
            $candidate = array();

            try {

                $user->email = $request->input('email');
                $user->password = bcrypt($request->input('password'));
                $user->role = $request->input('role');
                $user->first_name = $request->input('first_name');
                $user->last_name = $request->input('last_name');
                $user->save();

                $state->user_id = $user->user_id;
                $state->nra_state = $request->input('nra_state');
                $state->name = $request->input('name');
                $state->notify_state = $request->input('notify_state');
                $state->active = $request->input('active');
                $state->save();

                $destinationPath =  base_path() . '/public/images/users/';
                $imageName = '';

                $id = $user->user_id;
                $imageName = 'user'.$id.'image.jpg';
                if ($request->input('image_url')) {
                    $data = base64_decode($request->input('image_url'));
                    file_put_contents($destinationPath.$imageName, $data);
                    $user->image_url = '/images/users/'. $imageName;
                }
                
                $user->save();

                if ($request->input('role') == 'admin'){

                    $admin = new Admin;
                    $admin->user_id = $user->user_id;
                    $admin->name = $request->input('name');
                    $admin->email = $request->input('email');
                    $admin->save();
                    $candidate = $admin;

                } else if ($request->input('role') == 'regular') {
                    $candidate = $user;
                } else if($request->input('role') == 'dealer') {
                    $candidate = $user;
                } else {
                    return response()->json(array('error' => 'Unknown role.'));
                }

            } catch (Exception $e) {
               return response()->json(['error' => 'User already exists.'], HttpResponse::HTTP_CONFLICT);
            }

            $token = JWTAuth::fromUser($user);

            $candidate->email = $request->email;

            if ($request->image_url){
                $candidate->image_url = $request->image_url;   
            }

            $status = 0;
            return response()->json(compact(['token', 'candidate', 'state', 'status']));
        } 
        
        
    }

    public function editUser(Request $request)
    {

        $destinationPath =  base_path() . '/public/images/users/';
        $imageName = '';

        $id = $request->input('user_id');
        $imageName = 'user'.$id.'image.jpg';
        if ($request->input('image_url')) {
            $data = base64_decode($request->input('image_url'));
            file_put_contents($destinationPath.$imageName, $data);
        }

        $user = User::find($id);
        $user->image_url = '/images/users/'. $imageName;
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = $request->input('role');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');     
        $user->save();

        $state = State::find($request->state_id);
        $state->user_id = $user->user_id;
        $state->nra_state = $request->input('nra_state');
        $state->name = $request->input('name');
        $state->notify_state = $request->input('notify_state');
        $state->active = $request->input('active');
        $state->save();

        $user_modify = $user;
        $user_modify->image_url = $user->image_url;
        $token = JWTAuth::fromUser($user);
        $status = 0;
        return response()->json(compact([ 'token', 'user_modify', 'state', 'status']));
    }

    public function forgetPassword(Request $request) {
        
        define('email', $request->email);
        $user_exist = User::where('email', email)->get();
        if (!count($user_exist)) {
            # if username already exist...
            return response()->json(array('error' => "This is dosen't exists."));
        }

        $user = User::where('email', email)->first();
        $new_pass = $this->generateRandomString();
        $user->password = bcrypt($new_pass);
        $user->save(); 
        $data = ['password' => $new_pass];
        Mail::send('resetPassword', $data, function($message) {
            $message->to(email, 'JustGuns')->subject('Reset Password.');
        });
        return response()->json(array('status'=> 0));
    }

    function generateRandomString($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
