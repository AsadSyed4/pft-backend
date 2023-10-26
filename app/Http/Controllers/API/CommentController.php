<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Add a new comment.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'client_id' => 'required|numeric',
            'feedback_id' => 'required|numeric',
            'content' => 'required|string',
        ]);
        if ($validator->fails()) {
            return HttpResponse::json(new ResponseData($validator->errors(), HttpCodes::UnprocessableEntity, []));
        }

        try {
            $comment = Comment::create([
                'client_id' => $request->client_id,
                'feedback_id' => $request->feedback_id,
                'content' => $request->content,
            ]);
            if (!$comment) {
                return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value, HttpCodes::ServiceUnavailable, []));
            }
            return HttpResponse::json(new ResponseData(HttpMessages::Created->value, HttpCodes::Created, $comment->toArray()));
        } catch (\Exception $e) {
            return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value . ':' . $e->getMessage(), HttpCodes::ServiceUnavailable, []));
        }
    }
}
