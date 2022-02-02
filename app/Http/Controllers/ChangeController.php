<?php

namespace App\Http\Controllers;

use App\Models\Change;
use App\Models\User;
use App\Models\UsersChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChangeController extends Controller
{
    // Создание смены
    public function create(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 1) {
                    $validator = Validator::make($request->all(), [
                        "date_start" => "required|string",
                        "date_end" => "required|string",
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

                    $people = new Change([
                        "date_start" => $request->get("date_start"),
                        "date_end" => $request->get("date_end"),
                    ]);

                    $people->save();

                    return response()->json([
                        "data" => [
                            "change" => "Ok"
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
    // Закрытие смены
    public function close(Request $request)
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

                    $change = Change::all()->where('id', $request->get("id"))->first();
                    $change->closed = true;
                    $change->save();

                    return response()->json([
                        "data" => [
                            "info" => "Смена закрыта"
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
    // Добавить пользователя в смену
    public function addUser(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 1) {
                    $validator = Validator::make($request->all(), [
                        "user_id" => "required|integer",
                        "change_id" => "required|integer",
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

                    $people = new UsersChange([
                        "change_id" => $request->get("change_id"),
                        "user_id" => $request->get("user_id"),
                    ]);

                    $people->save();

                    return response()->json([
                        "data" => [
                            "user" => "add"
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
    // Снять пользователя в смену
    public function removeUser(Request $request)
    {
    }
}
