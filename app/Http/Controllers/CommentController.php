<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShowCommentRequest;
use App\Models\User;
use App\Models\Comment;
use App\Models\Lecture;
use App\Models\Conference;
use App\Jobs\NewCommentJob;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(StoreCommentRequest $request)
    {
        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'lecture_id' => $request->lecture_id,
            'content' => $request->content,
        ]);

        $lecture = Lecture::find($request->lecture_id);
        $conference = Conference::find($lecture->conference_id);

        NewCommentJob::dispatch(
            Auth::user()->firstname,
            Auth::user()->lastname,
            $conference->title,
            env('APP_URL') . 'conferences/' . $conference->id,
            $lecture->title,
            env('APP_URL') . 'lectures/' . $lecture->id,
            User::where('id', $lecture->user_id)->first()->email
        );

        return new CommentResource($comment);
    }

    public function show($lectureId, ShowCommentRequest $request)
    {
        return response()->json(Comment::with(['user'])->where('lecture_id', $lectureId)->orderBy('updated_at', 'DESC')->get());
    }

    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update([
            'content' => $request->content
        ]);

        return new CommentResource($comment);
    }
}
