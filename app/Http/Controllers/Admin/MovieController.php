<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Movie;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    public function index() {
        $movies = Movie::all();
        return view('admin.movies', ['movies' => $movies]);
    }

    public function create() {
        return view('admin.movie-create');
    }

    public function edit($id) {
        $movie = Movie::find($id);
        return view('admin.movie-edit', ['movie' => $movie]);
    }

    public function store(Request $request) {
        $data = $request->except('_token');

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'required|image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required',
        ]);

        $smallThumbnail = $request->small_thumbnail;
        $largeThumbnail = $request->large_thumbnail;

        // random imageName
        $originalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
        $originalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();

        // upload gambar
        $smallThumbnail->storeAs('public/thumbnail', $originalSmallThumbnailName);
        $largeThumbnail->storeAs('public/thumbnail', $originalLargeThumbnailName);

        $data['small_thumbnail'] = $originalSmallThumbnailName;
        $data['large_thumbnail'] = $originalLargeThumbnailName;

        //dd($data);
        // menyimpan gambar di table movie
        Movie::create($data);
        
        return redirect()->route('admin.movie')->with('success', 'Movie created');
        // dd(Str::random(10).$largeThumbnail->getClientOriginalName());
        // dd($originalSmallThumbnailName);
    }

    public function update(Request $request, $id) {
        $data = $request->except('_token');

        $request->validate([
            'title' => 'required|string',
            'small_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'large_thumbnail' => 'image|mimes:jpeg,jpg,png',
            'trailer' => 'required|url',
            'movie' => 'required|url',
            'casts' => 'required|string',
            'categories' => 'required|string',
            'release_date' => 'required|string',
            'about' => 'required|string',
            'short_about' => 'required|string',
            'duration' => 'required|string',
            'featured' => 'required',
        ]);

        $movie = Movie::find($id);

        if ($request -> small_thumbnail) {
            // save new image
            $smallThumbnail = $request->small_thumbnail;
            
            // random imageName
            $originalSmallThumbnailName = Str::random(10).$smallThumbnail->getClientOriginalName();
            
            // upload gambar
            $smallThumbnail->storeAs('public/thumbnail', $originalSmallThumbnailName);
            
            // original name
            $data['small_thumbnail'] = $originalSmallThumbnailName;

            // delete old image
            Storage::delete('public/thumbnail/'.$movie->small_thumbnail);
        }

        if ($request->large_thumbnail) {
            // save new image
            $largeThumbnail = $request->large_thumbnail;

            // random imageName
            $originalLargeThumbnailName = Str::random(10).$largeThumbnail->getClientOriginalName();

            // upload gambar
            $largeThumbnail->storeAs('public/thumbnail', $originalLargeThumbnailName);

            // original name
            $data['large_thumbnail'] = $originalLargeThumbnailName;

            // delete old image
            Storage::delete('public/thumbnail/'.$movie->large_thumbnail);
        }

        $movie->update($data);

        return redirect()->route('admin.movie')->with('success', 'Movie updated');
    }
}
