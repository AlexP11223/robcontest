<?php

namespace App\Http\Controllers;

use App\Models\Contest;
use Illuminate\Http\Request;
use App\Models\Post;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);
        $contest = Contest::current();
        $archivedContests = Contest::archived();

        return view('main', [
            'posts' => $posts,
            'currentContest' => $contest,
            'archivedContests' => $archivedContests ]);
    }
}
