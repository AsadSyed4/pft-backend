<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    /**
     * Change visibility of comment.
     */
    public function change_visibility(Request $request): JsonResponse
    {
        $comment = Comment::find($request->id);
        if (!$comment) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        try {
            $updated = $comment->update([
                'visible' => $request->visible
            ]);
            if (!$updated) {
                return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value, HttpCodes::ServiceUnavailable, []));
            }
            return HttpResponse::json(new ResponseData(HttpMessages::Updated->value, HttpCodes::Ok, []));
        } catch (\Exception $e) {
            return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value . ':' . $e->getMessage(), HttpCodes::ServiceUnavailable, []));
        }
    }
}
