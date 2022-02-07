<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SignupRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticateController extends Controller
{
    private $success = false;
    private $message = '';
    private $data = [];

    /**
     * This is used to create a user sign up
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signUp(SignupRequest $request)
    {
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['name'] = $input['first_name'] . ' ' . $input['last_name'];
        $input['user_type'] = 2;
        $input['created_at'] = currentDateTime();
        $input['updated_at'] = currentDateTime();
        $user = User::create($input);
        $token = $user->createToken('MyApp')->accessToken;
        $this->data['token'] = $token;
        $this->data['user_id'] = $user->id;
        $this->data['name'] = $user->name;
        $this->data['email'] = $user->email;
        $this->data['phone'] = $user->phone;
        $this->data['user_type'] = $user->user_type;
        $this->success = true;
        $this->message = 'User created successfully';

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    }

    /**
     * This is used to login user
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = \Validator::make($input, [
            'email' => ['required', 'string', 'email'],
            'password' => ['required'],
        ]);
        if ($validator->fails()) {
            $this->message = formatErrors($validator->errors()->toArray());
        } else {
            $this->message = 'No user found on this email';
            $user = User::where('email', $input['email'])->first();
            if ($user) {
                if (Hash::check($input['password'], $user->password)) {
                    $token = $user->createToken('MyApp')->accessToken;
                    $this->data['token'] = $token;
                    $this->data['user'] = $user;
                    $this->success = true;
                    $this->message = 'User login successfully';
                } else {
                    $this->message = 'Incorrect Password';
                }
            }
        }

        return response()->json(['success' => $this->success, 'message' => $this->message, 'data' => $this->data]);
    }
}
