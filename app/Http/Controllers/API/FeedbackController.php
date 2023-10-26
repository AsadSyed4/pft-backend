<?php

namespace App\Http\Controllers\API;

use App\Models\Feedback;
use App\Http\Controllers\Controller;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Get all feedbacks.
     */
    public function get(): JsonResponse
    {
        $feedbacks = Feedback::with([
            'client' => function ($query) {
                $query->select('id','name');
            },
        ])->get();
        if (!$feedbacks) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        return HttpResponse::json(new ResponseData(HttpMessages::Deleted->value, HttpCodes::Ok, $feedbacks->toArray()));
    }

    /**
     * Display the feedback by id.
     */
    public function get_by_id($id): JsonResponse
    {
        $feedback = Feedback::with([
            'client' => function ($query) {
                $query->select('id', 'name');
            },
            'comments' => function ($query) {
                $query->where('visible', 1);
            },
            'comments.client' => function ($query) {
                $query->select('id', 'username');
            },
        ])->find($id);
        if (!$feedback) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        return HttpResponse::json(new ResponseData(HttpMessages::Found->value, HttpCodes::Ok, $feedback->toArray()));
    }

    /**
     * Add a new feedback.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'category' => 'required|string',
            'client_id' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return HttpResponse::json(new ResponseData($validator->errors(), HttpCodes::UnprocessableEntity, []));
        }

        try {
            $comment = Feedback::create([
                'title' => $request->title,
                'description' => $request->description,
                'category' => $request->category,
                'client_id' => $request->client_id,
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
