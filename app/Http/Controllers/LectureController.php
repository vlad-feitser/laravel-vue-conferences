<?php

namespace App\Http\Controllers;

use App\Http\Requests\AllFavoritesLectureRequest;
use App\Http\Requests\DeleteLectureRequest;
use App\Http\Requests\DownloadLectureRequest;
use App\Http\Requests\EditLectureRequest;
use App\Http\Requests\FavoriteLectureRequest;
use App\Http\Requests\IndexLectureRequest;
use App\Models\User;
use App\Models\Comment;
use App\Models\Lecture;
use App\Models\Conference;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LectureRequest;
use App\Http\Requests\ShowLectureRequest;
use App\Http\Requests\ShowWithConferenceLectureRequest;
use App\Http\Requests\StoreLectureRequest;
use App\Http\Requests\UnfavoriteLectureRequest;
use App\Http\Requests\UpdateLectureRequest;
use App\Http\Resources\LectureResource;
use App\Jobs\LectureDeleteJob;
use App\Jobs\NewLectureJob;
use App\Jobs\UpdateLectureTimeJob;
use Illuminate\Support\Facades\Storage;

class LectureController extends Controller
{
    public function index(IndexLectureRequest $request)
    {
        return response()->json(LectureResource::collection(Lecture::all()));
    }

    public function store(StoreLectureRequest $request, $conferenceId)
    {
        $lecture = new Lecture();
        $lecture->user_id = Auth::user()->id;
        $lecture->conference_id = $conferenceId;
        $lecture->category_id = $request->category_id;
        $lecture->title = $request->title;
        $lecture->start_time = $request->start_time;
        $lecture->end_time = $request->end_time;
        $lecture->description = $request->description;
        if ($request->has('presentation')) {
            $file = $request->file('presentation');
            $fileName = date('i') . $file->getClientOriginalName();
            $lecture['presentation'] = $fileName;
            Storage::disk('public')->putFileAs('', $request->presentation, $fileName);
        }
        $lecture->save();

        $users = User::where('type', 'Listener')->whereHas('conferences', function ($query) use ($conferenceId) {
            $query->where('conference_id', '=', $conferenceId);
        })->get();

        if ($users) {
            foreach ($users as $user) {
                NewLectureJob::dispatch(
                    Auth::user()->firstname,
                    Conference::find($conferenceId)->title,
                    env('APP_URL') . 'conferences/' . $conferenceId,
                    $lecture->title,
                    env('APP_URL') . 'lectures/' . $lecture->id,
                    $lecture->start_time,
                    $lecture->end_time,
                    $user->email
                );
            }
        }

        return new LectureResource($lecture);
    }

    public function showWithConference($conferenceId, ShowWithConferenceLectureRequest $request)
    {
        return response()->json(['lectures' => Lecture::with(['comments'])->where('conference_id', $conferenceId)->orderBy('start_time')->get()]);
    }

    public function update(UpdateLectureRequest $request, Lecture $lecture)
    {
        $old_start = $lecture->start_time;
        $old_end = $lecture->end_time;

        if ($request->has('presentation')) {
            Storage::delete('presentations/' . $lecture->presentation);
            $file = $request->file('presentation');
            $fileName = date('i') . $file->getClientOriginalName();
            $lecture->update(['presentation' => $fileName]);
            Storage::disk('public')->putFileAs('', $request->presentation, $fileName);
        }

        $lecture->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'start_time' => $request->start_time,
            'end_time' =>  $request->end_time,
            'description' => $request->description
        ]);

        if ($old_start !== $request->start_time || $old_end !== $request->end_time) {

            $users = User::where('type', 'Listener')->whereHas('conferences', function ($query) use ($lecture) {
                $query->where('conference_id', '=', $lecture->conference_id);
            })->get();

            if ($users) {
                foreach ($users as $user) {
                    UpdateLectureTimeJob::dispatch(
                        Auth::user()->firstname,
                        Conference::find($lecture->conference_id)->title,
                        env('APP_URL') . 'conferences/' . $lecture->conference_id,
                        $lecture->title,
                        env('APP_URL') . 'lectures/' . $lecture->id,
                        $lecture->start_time,
                        $lecture->end_time,
                        $user->email
                    );
                }
            }
        }

        return new LectureResource($lecture);
    }

    public function delete(Lecture $lecture, DeleteLectureRequest $request)
    {
        if (Auth::user()->type === 'Admin') {
            $conference = Conference::find($lecture->conference_id);
            LectureDeleteJob::dispatch(
                $conference->title,
                env('APP_URL') . 'conferences/' . $conference->id,
                User::where('id', $lecture->user_id)->first()->email
            );
        }

        Storage::disk('public')->delete($lecture->presentation);

        Comment::where('lecture_id', $lecture->id)->delete();
        $lecture->delete();

        return response()->json($lecture);
    }

    public function edit(Lecture $lecture, EditLectureRequest $request)
    {
        return new LectureResource($lecture);
    }

    public function show(Lecture $lecture, ShowLectureRequest $request)
    {
        return response()->json($lecture->where('id', $lecture->id)->with(['categories'])->first());
    }

    public function downloadPresentation(Lecture $lecture, DownloadLectureRequest $request)
    {
        $this->authorize('view', Lecture::class);

        return Storage::disk('public')->download($lecture->presentation);
    }

    public function favorite(Lecture $lecture, FavoriteLectureRequest $request)
    {
        Auth::user()->lecturesFavorites()->attach($lecture);
        return response()->json(Auth::user()->lecturesFavorites);
    }

    public function unfavorite(Lecture $lecture, UnfavoriteLectureRequest $request)
    {
        Auth::user()->lecturesFavorites()->detach($lecture);

        return response()->json(Auth::user()->lecturesFavorites);
    }

    public function favorites(User $user, AllFavoritesLectureRequest $request)
    {
        return response()->json($user->lecturesFavorites);
    }
}
