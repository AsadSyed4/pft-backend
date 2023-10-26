<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Services\Utilities\HttpResponse;
use App\Services\Utilities\HttpCodes;
use App\Services\Utilities\HttpMessages;
use App\Contracts\ResponseData;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\JsonResponse;

class FeedbackController extends Controller
{
    /**
     * Display the Feedbacks page.
     */
    public function get(Request $request): Response
    {
        $feedbacks = Feedback::with([
            'client' => function ($query) {
                $query->select('id', 'username');
            }
        ])->paginate(6);
        return Inertia::render('Feedbacks/Index', [
            'feedbacks' => $feedbacks,
        ]);
    }

    /**
     * Display the feedback by id.
     */
    public function get_by_id($id): JsonResponse
    {
        $feedback = Feedback::with([
            'client' => function ($query) {
                $query->select('id', 'username');
            },
            'comments.client' => function ($query) {
                $query->select('id', 'username');
            }
        ])->find($id);
        if (!$feedback) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        return HttpResponse::json(new ResponseData(HttpMessages::Found->value, HttpCodes::Ok, $feedback->toArray()));
    }

    /**
     * Delete the feedback.
     */
    public function destroy($id): JsonResponse
    {
        $feedback = Feedback::find($id);
        if (!$feedback) {
            return HttpResponse::json(new ResponseData(HttpMessages::NotFound->value, HttpCodes::NotFound, []));
        }

        try {
            $deleted = $feedback->delete();
            if (!$deleted) {
                return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value, HttpCodes::ServiceUnavailable, []));
            }
            return HttpResponse::json(new ResponseData(HttpMessages::Deleted->value, HttpCodes::Ok, []));
        } catch (\Exception $e) {
            return HttpResponse::json(new ResponseData(HttpMessages::ServiceUnavailable->value . ':' . $e->getMessage(), HttpCodes::ServiceUnavailable, []));
        }
    }
}
