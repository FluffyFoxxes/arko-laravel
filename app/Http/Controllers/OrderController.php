<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    // Оформить заказ
    public function submit(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 2) {
                    $validator = Validator::make($request->all(), [
                        "user_id" => "required|integer",
                        "name" => "required|string",
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

                    $order = new Order([
                        "user_id" => $request->get("user_id"),
                        "name" => $request->get("name"),
                    ]);

                    $order->save();

                    return response()->json([
                        "data" => [
                            "order" => "add"
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
    // Просмотр своих заказов
    public function allUser(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    $validator = Validator::make($request->all(), [
                        "user_id" => "required|integer",
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
                    return response()->json(["data" => Order::all()->where("id", $request->get("user_id"))]);
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
    // Изменение статуса на оплачен - 3
    public function statusSetPay(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    $validator = Validator::make($request->all(), [
                        "order_id" => "required|integer",
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

                    $order = Order::all()->where("id", $request->get("order_id"))->first();
                    $order->status = 3;
                    $order->save();

                    return response()->json(["data" => "Set status pay"]);
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
    // Изменение статуса на отменен - 4
    public function statusSetAbort(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    $validator = Validator::make($request->all(), [
                        "order_id" => "required|integer",
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

                    $order = Order::all()->where("id", $request->get("order_id"))->first();
                    $order->status = 4;
                    $order->save();

                    return response()->json(["data" => "Set status Abort"]);
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
    // Изменение статуса на выполнено - 2
    public function statusSetDone(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    $validator = Validator::make($request->all(), [
                        "order_id" => "required|integer",
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

                    $order = Order::all()->where("id", $request->get("order_id"))->first();
                    $order->status = 2;
                    $order->save();

                    return response()->json(["data" => "Set status done"]);
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
    // Просмотр всех принятых заказов на смену
    public function allByPay(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    return response()->json(["data" => Order::all()->where("status", 3)]);
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
    // Просмотр всех заказов
    public function all(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    return response()->json(["data" => Order::all()]);
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
    // Просмот коткретного заказа
    public function item(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 3) {
                    $validator = Validator::make($request->all(), [
                        "order_id" => "required|integer",
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

                    $order = Order::all()->where("id", $request->get("order_id"))->first();

                    return response()->json(["data" => $order]);
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
