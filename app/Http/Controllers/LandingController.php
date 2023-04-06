<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;

class LandingController extends Controller
{
    public function index()
    {
    	$posts = Post::get();
    	$data = array(
    		'posts'=>$posts
    	);
        return view('welcome',$data);
    }

    public function show($id)
    {
    	$posts = Post::find($id);
    	$data = array(
    		'posts'=>$posts
    	);
        return view('detail_post',$data);
    }
}
