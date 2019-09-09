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
        $music = Music::orderBy('updated_at', 'desc')->first();
        return view('home', [
            'last_added' => $music,
            'musics' => Music::all()
        ]);
    }

    public function categoriesPage()
    {

        $categories = [];

        foreach(Category::all() as $category) {

            $categories[$category->id] = [
                'name' => $category->name,
                'musics' => [
                    'active' => $category->musics()->byTag('Active'),
                    'passive' => $category->musics()->byTag('Passive')
                ]
            ];
        }

        return view('categories', [
            'categories' => $categories
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
        Music::destroy($id);
        return redirect('categories');
    }
}
