<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    // Написать комментарий
    public function create(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 2) {
                    $validator = Validator::make($request->all(), [
                        "user_id" => "required|integer",
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

                    $comment = new Comment([
                        "change_id" => $request->get("change_id"),
                        "order_id" => $request->get("order_id"),
                    ]);

                    $comment->save();

                    return response()->json([
                        "data" => [
                            "comment" => "add"
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
    // Просмотр отзывов других клиентов
    public function all(Request $request)
    {
        $bearer = $request->header('authorization');
        if ($bearer != "") {
            $token = explode(" ", $bearer)[1];
            $user = User::all()->where('token', $token)->first();
            if ($user != null) {
                if ($user->role_id == 2) {
                    return response()->json(["data" => Comment::all()]);
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
