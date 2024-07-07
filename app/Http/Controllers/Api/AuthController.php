<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //user register
    public function userRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
        ]);

        $data = $request->all(); //Request data dari semua validate
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'users';

        $user = User::create($data);

        return response()->json([
            'status' => 'success',
            'message' => 'User Register Successfully',
            'data' => $user
        ]);
    }

    //restaurant register
    public function restaurantRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'restaurant_name' => 'required|string',
            'restaurant_address' => 'required|string',
            'photo' => 'required|image',
            'latlong' => 'required|string',
        ]);

        $data = $request->all(); //Request data dari semua validate
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'restaurant';

        $user = User::create($data);

        //check if photo is uploaded
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $user->photo = $photo_name;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Restaurant Register Successfully',
            'data' => $user
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Restaurant Register Successfully',
            'data' => $user
        ]);
    }

    //driver register
    public function driverRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'required|string',
            'license_plate' => 'required|string',
            'photo' => 'required|image',
        ]);

        $data = $request->all(); //Request data dari semua validate
        $data['password'] = Hash::make($data['password']);
        $data['roles'] = 'driver';

        $user = User::create($data);

        //check if photo is uploaded
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photo_name = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images'), $photo_name);
            $user->photo = $photo_name;
            $user->save();
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Driver Register Successfully',
            'data' => $user
        ]);
    }


    //login
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Invalid Credentials'
            ]);
        }

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Login Successfully',
            'data' => [
                'user' => $user,
                'token' => $token,
            ]
        ]);
    }

    //logout
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Logout Successfully'
        ]);
    }

    //update latlong user
    public function updateLatLong(Request $request)
    {
        $request->validate([
            'latlong' => 'required|string',
        ]);

        $user = $request->user();
        $user->latlong = $request->latlong;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Update Latlong Successfully',
            'data' => $user
        ]);
    }

    //get all user
    public function getAllUser()
    {
        $users = User::all();

        return response()->json([
            'status' => 'success',
            'message' => 'Get All User Successfully',
            'data' => $users,
        ]);
    }

    //get all driver
    public function getAllDriver()
    {
        $driver = User::where('roles', 'driver')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Get All Driver Successfully',
            'data' => $driver,
        ]);
    }

    //get all restaurant
    public function getAllRestaurant()
    {
        $restaurant = User::where('roles', 'restaurant')->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Get All Restaurant Successfully',
            'data' => $restaurant,
        ]);
    }

    //destroy
    public function deleteUser(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'failed',
                'message' => 'User not found'
            ]);
        }

        $user->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Delete User Successfully',
            'data' => $user
        ]);
    }
}
