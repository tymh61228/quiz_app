<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function top()
    {
        $categories = Category::all();
        return view('play.top', [
            'categories' => $categories,
        ]);
    }
}
