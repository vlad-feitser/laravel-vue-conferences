<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comment;
use App\Models\Lecture;
use App\Models\Conference;
use App\Jobs\NewListenerJob;
use App\Jobs\ConferenceDeleteJob;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\DeleteConferenceRequest;
use App\Http\Resources\ConferenceResource;
use App\Http\Requests\EditConferenceRequest;
use App\Http\Requests\JoinConferenceRequest;
use App\Http\Requests\ShowConferenceRequest;
use App\Http\Requests\StoreConferenceRequest;
use App\Http\Requests\UnjoinConferenceRequest;
use App\Http\Requests\UpdateConferenceRequest;

class ConferenceController extends Controller
{
    public function index()
    {
        return response()->json(Conference::paginate(3));
    }

    public function store(StoreConferenceRequest $request)
    {
        $conference = Conference::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'country' => $request->country
        ]);

        return new ConferenceResource($conference);
    }

    public function show(Conference $conference, ShowConferenceRequest $request)
    {
        return new ConferenceResource($conference->where('id', $conference->id)->with(['categories'])->first());
    }

    public function edit(Conference $conference, EditConferenceRequest $request)
    {
        return new ConferenceResource($conference);
    }

    public function delete(Conference $conference, DeleteConferenceRequest $request)
    {
        $users = User::where('type', '!=', 'Admin')->whereHas('conferences', function ($query) use ($conference) {
            $query->where('conference_id', '=', $conference->id);
        })->get();

        if ($users) {
            foreach ($users as $user) {
                ConferenceDeleteJob::dispatch(
                    $conference->title,
                    $user->email
                );
            }
        }

        Comment::where('lecture_id', Lecture::where('conference_id', $conference->id));
        Lecture::where('conference_id', $conference->id)->delete();
        $conference->delete();

        return response()->json($conference);
    }

    public function update(UpdateConferenceRequest $request, Conference $conference)
    {
        $conference->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'date' => $request->date,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'country' => $request->country
        ]);

        return new ConferenceResource($conference);
    }

    public function join(Conference $conference, JoinConferenceRequest $request)
    {
        Auth::user()->conferences()->attach($conference);

        if (Auth::user()->type === 'Listener') {

            $users = User::where('type', 'Announcer')->whereHas('conferences', function ($query) use ($conference) {
                $query->where('conference_id', '=', $conference->id);
            })->get();

            if ($users) {
                foreach ($users as $user) {
                    NewListenerJob::dispatch(
                        Auth::user()->firstname,
                        Auth::user()->lastname,
                        $conference->title,
                        env('APP_URL') . 'conferences/' . $conference->id,
                        $user->email
                    );
                }
            }
        }

        return response()->json(Auth::user()->conferences);
    }

    public function unjoin(Conference $conference, UnjoinConferenceRequest $request)
    {
        if (Auth::user()->type === 'Announcer' && Lecture::where('user_id', Auth::user()->id)) {
            foreach (Lecture::where('conference_id', $conference->id) as $lecture) {
                Comment::where('lecture_id', $lecture->id)->delete();
            }
            Lecture::where('user_id', Auth::user()->id)->where('conference_id', $conference->id)->delete();
        }

        Auth::user()->conferences()->detach($conference);

        return response()->json(Auth::user()->conferences);
    }

    public function twitter()
    {
        return response()->json(config('twitter_config')['share']);
    }
}
