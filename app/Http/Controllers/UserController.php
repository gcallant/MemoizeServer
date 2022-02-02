<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Stores a new user in the database along with their basic info.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|phone:US,mobile|min:10|unique:users',
            'public_key' => 'required'
        ]);

        $user = User::create($attributes);

        if($user !== null)
        {
            return response()->json(["id" => $user->id], 201);
        }

        return response()->json("Error validating user", 400);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255|min:2',
            'email' => 'required|string|email|max:255|unique:users|confirmed',
            'phone' => 'required|phone:US|min:10|unique:users',
            'public_key' => 'required'
        ]);
    }
}
