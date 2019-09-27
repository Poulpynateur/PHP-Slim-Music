<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Channel;
use App\Models\Category;
use App\Models\Music;
use App\Models\Tag;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'last_added' => Music::orderBy('updated_at', 'desc')->first(),
            'musics' => Music::all()
        ]);
    }

    public function categoriesPage()
    {
        return view('categories', [
            'categories' => Category::all()
        ]);
    }

    public function channelsPage()
    {
        return view('channels', [
            'all' => Channel::where('favorite', false)->get(),
            'favorites' => Channel::where('favorite', true)->get()
        ]);
    }

    public function deleteMusic($id) {
        \App\Models\MusicTag::where('music_id', $id)->delete();
        Music::destroy($id);
        return redirect()->route('categories');
    }

    public function about() {
        return view('about');
    }
}
