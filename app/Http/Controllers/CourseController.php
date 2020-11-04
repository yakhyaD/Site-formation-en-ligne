<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;
use App\Models\Course;
use App\Models\Episode;
use Illuminate\Http\Request;
use App\Youtube\YoutubeServices;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('user')
        ->select('courses.*', DB::raw(
            '(SELECT COUNT(DISTINCT(user_id))
              FROM completions
              INNER JOIN episodes ON completions.episode_id = episodes.id
              WHERE episodes.course_id = courses.id
              ) AS participants'
        ))->addSelect(DB::raw(
            '(
              SELECT SUM(duration)
              FROM episodes
              WHERE episodes.course_id = courses.id
             ) AS total_duration'
        ))->withCount('episodes')->latest()->paginate(5);

        return Inertia::render('Courses/Index', compact('courses'));
    }

    public function show(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();

        $watched =Auth::user()->episodes;

        return Inertia::render('Courses/show',compact('course', 'watched'));
    }

    public function store(Request $request, YoutubeServices $ybt)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['required', 'array'],
            'episodes.*.title' => 'required',
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required',
        ]);

        $course = Course::create($request->all());

        foreach($request['episodes'] as $episode){
            $episode['course_id'] = $course->id;
            $episode['duration'] = $ybt->handleYoutubeVideoDuration($episode['video_url']);

            Episode::create($episode);
        }

        return Redirect::route('courses.index')->with('success', 'Félicitation, la formation a bien été créée');

    }

    public function edit(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();

        if(Gate::allows('update-course', $course)) {
            // The user can update the post...
            return Inertia::render('Courses/Edit', ['course' => $course]);

        }
        return Redirect::route('courses.index')->with('error', 'This action is not authorizated');
    }

    public function update(Request $request, YoutubeServices $ybt)
    {
        $course = Course::where('id', $request->id)->with('episodes')->first();

        if (Gate::allows('update-course', $course)) {
            // The current user can update the post...
            $course->episodes()->delete();

            foreach($request->episodes as $episode){

                $episode['course_id'] = $course->id;
                $episode['duration'] = $ybt->handleYoutubeVideoDuration($episode['video_url']);

                Episode::create($episode);
                return Redirect::route('courses.index')->with('success', 'La formation a bien été modifiée');
            }
        }

    }

    public function toggleProgress(Request $request)
    {
        $id = $request->input('episodeId');
        $user = Auth::user();

        $user->episodes()->toggle($id);

        return $user->episodes;
    }

    public function delete(int $id)
    {
        $course = Course::where('id', $id)->with('episodes')->first();

        if (Gate::allows('update-post', $course)) {
            // The current user can update the post...
            $course->delete();

            return Redirect::route('courses.index')->with('success', 'La formation a bien été supprimée !!');
        }


    }
}
