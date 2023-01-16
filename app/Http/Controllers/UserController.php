<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Resources\Book as ResourcesBook;
use App\Http\Resources\Login;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function login(LoginRequest $request)
    {
        $data = $request->validated();
        $user = User::where('email', $data['email'])->first();
        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return response()->json([], 406);
        }

        return new Login($user);
    }

    public function logout()
    {
        return response()->json([], 202);
    }

    public function generate()
    {
        $email = fake()->email();
        $password = '123456';

        User::create([
            'name' => fake()->name(),
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        return ['user' => $email, 'password' => $password];
    }
}
