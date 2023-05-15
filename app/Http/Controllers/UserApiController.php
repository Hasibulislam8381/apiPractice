<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class UserApiController extends Controller
{
    //
    public function showUser($id = null)
    {
        if ($id == '') {
            $users = User::get();
            return response()->json(['hi' => $users], 200);
        } else {
            $users = User::find($id);
            return response()->json(['hi' => $users], 200);
        }
    }
    //get api
    public function addUser(Request $request)
    {
        if ($request->ismethod('post')) {
            $data = $request->all();

            //validation
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users', //users table a email gulo unique hobe
                'password' => 'required',
            ];
            $customMessage = [
                'name.required' => 'Name is required',
                'email.required' => 'Email is required',
                'password.required' => 'Password is required',
            ];
            $validatior = validator($data, $rules, $customMessage);
            if ($validatior->fails()) {
                return response()->json($validatior->errors(), 404);
            }
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = bcrypt($data['password']);
            $user->save();
            $message = 'User succesfully added';
            return response()->json(['message' => $message], 201);
        }
    }
    //post api
    public function addMultipleUser(Request $request)
    {
        if ($request->ismethod('post')) {
            $data = $request->all();

            $check = [
                'users.*.name' => 'required',
                'users.*.email' => 'required|email|unique:users',
                'users.*.password' => 'required',
            ];
            $customMessage = [
                'users.*.name.required' => 'Name is required',
                'users.*.email.required' => 'Email is required',
                'users.*.password.required' => 'Password is required',
            ];
            $validate = validator($data, $check, $customMessage);
            if ($validate->fails()) {
                return response()->json([$validate->errors(), 404]);
            }
            foreach ($data['users'] as $addUser) {
                $user = new User();
                $user->name = $addUser['name'];
                $user->email = $addUser['email'];
                $user->password = $addUser['password'];
                $user->save();
                $message = 'User cretaed succesfuly';
            }
            return response()->json(['message' => $message], 202);
        }
    }
    //Put api 
    public function updateUser(Request $request, $id)
    {
        if ($request->ismethod('put')) {
            $data = $request->all();

            $check = [
                'name' => 'required',
                'password' => 'required',
            ];
            $errorMessage = [
                'name.required' => 'Name is Required',
                'password.required' => 'Password is Required',
            ];
            $validate = validator($data, $check, $errorMessage);
            if ($validate->fails()) {
                return response()->json($validate->errors());
            }

            $user = User::findOrFail($id);
            $user->name = $data['name'];
            $user->password = $data['password'];
            $user->save();
            $message = 'Update succesfull';
            return response()->json(['message' => $message], 202);
        }
    }
}
