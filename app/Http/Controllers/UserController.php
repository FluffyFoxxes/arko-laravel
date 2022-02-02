<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // Создание пользователя
    public function registration(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 1) {
                    $validator = Validator::make($request->all(), [
                        "name" => "required|string",
                        "login" => "required|string",
                        "role_id" => "required|integer"
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            "error" => [
                                "code" => 422,
                                "message" => "Validation error",
                                "errors" => $validator->errors()
                            ],
                        ], 422);
                    }



                    $password = bin2hex(openssl_random_pseudo_bytes(16));

                    $people = new User([
                        "name" => $request->get("name"),
                        "login" => $request->get("login"),
                        "status" => $request->get("status"),
                        "role_id" => $request->get("role_id"),
                        "password" => $password,
                    ]);

                    $people->save();

                    return response()->json([
                        "data" => [
                            "password" => $password
                        ]
                    ]);
                } else {
                    return response()->json(
                        ["code" => 403, "message" => "Forbidden for you"],
                        403
                    );
                }
            } else {
                return response()->json(
                    ["code" => 403, "message" => "Login failed"],
                    403
                );
            }
        } else {
            return response()->json(
                ["code" => 403, "message" => "Login failed"],
                403
            );
        }
    }
    // Вход пользователя
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "login" => "required|string",
            "password" => "required|string"
        ]);

        if ($validator->fails()) {
            return response()->json(
                ["error" => ["code" => 401, "message" => "Authentication failed"]],
                401
            );
        }

        $user = User::all()->where('login', $request->input("login"))->first();

        if ($user != null) {
            if ($user->password == $request->input("password")) {
                if ($user->active == true) {
                    $token = bin2hex(openssl_random_pseudo_bytes(16));
                    $user->token = $token;
                    $user->save();
                    return response()->json(
                        ["data" => ["token" => $token]]
                    );
                } else {
                    return response()->json(
                        ["error" => "Пользователь был уволен"],
                        403
                    );
                }
            } else {
                return response()->json(
                    ["error" => ["code" => 401, "message" => "Authentication failed"]],
                    401
                );
            }
        } else {
            return response()->json(
                ["error" => ["code" => 401, "message" => "Authentication failed"]],
                401
            );
        }
    }
    // Просмотр всех пользователей
    public function all(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 1) {
                    return response()->json(
                        ["data" => User::all()]
                    );
                } else {
                    return response()->json(
                        ["code" => 403, "message" => "Forbidden for you"],
                        403
                    );
                }
            } else {
                return response()->json(
                    ["code" => 403, "message" => "Login failed"],
                    403
                );
            }
        } else {
            return response()->json(
                ["code" => 403, "message" => "Login failed"],
                403
            );
        }
    }
    // Увольнение работников
    public function dismissal(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 1) {
                    $validator = Validator::make($request->all(), [
                        "id" => "required|integer",
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            "error" => [
                                "code" => 422,
                                "message" => "Validation error",
                                "errors" => $validator->errors()
                            ],
                        ], 422);
                    }

                    $password = bin2hex(openssl_random_pseudo_bytes(16));

                    $people = User::all()->where('id', $request->get("id"))->first();
                    $people->active = false;
                    $people->save();

                    return response()->json([
                        "data" => [
                            "info" => "ПОльзователь уволен"
                        ]
                    ]);
                } else {
                    return response()->json(
                        ["code" => 403, "message" => "Forbidden for you"],
                        403
                    );
                }
            } else {
                return response()->json(
                    ["code" => 403, "message" => "Login failed"],
                    403
                );
            }
        } else {
            return response()->json(
                ["code" => 403, "message" => "Login failed"],
                403
            );
        }
    }
}
