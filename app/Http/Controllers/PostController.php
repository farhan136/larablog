<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Post;
// use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        $data = array();
        return view('post.index', $data);
    }

    public function gridview()
    {
        $posts = Post::get();

        return Datatables::of($posts)
	        ->addColumn('author', function ($post) {
	        	return $post->user->name;
	        })
	        ->editColumn('created_at', function ($post) {
	        	return $post->created_at->format('Y-M-d');
	        })
            ->addColumn('post_action', function ($post) {
                $button_edit = '';
                $button_delete = '';
                if($post->created_by == Auth::user()->id){
                    $button_edit = '<button data-id="'.$post->id.'" class="btn btn-sm btn-outline-warning tombol_edit">Edit</button>';
                    $button_delete = '<button data-id="'.$post->id.'" class="btn btn-sm btn-outline-danger tombol_delete">Delete</button>';
                }
                return $button_edit.' <button data-id="'.$post->id.'" class="btn btn-sm btn-outline-secondary tombol_detail">Show</button> '.$button_delete;
            })->addIndexColumn()->rawColumns(['post_action', 'author'])->make();
    }

    public function form($id = '', $module='')
    {
    	if($module == ''){
    		$title = 'Create';
    	}else{
    		$title = ucfirst($module);
    	}
        $post = Post::find($id);
        $data = array(
            'post'=>$post,
            'module'=>$module,
            'title'=>$title
        );
        return view('post.form', $data);
    }

    public function store(Request $request, $id = '')
    {
    	$request->validate([
		    'name' => 'required',
		    'description' => 'required',
		]);

        if($id == ''){
           	Post::create([
                'name'=> $request->name,
                'description'=> $request->description,
                'created_by' => Auth::user()->id,
            	'updated_by' => 0
            ]);
        }else{
            $post = Post::find($id);
            $post->name = $request->name;
            $post->description = $request->description;
            $post->updated_by = Auth::user()->id;
            $post->save();
        }
        echo "<script>window.opener.reloadDatatable();</script>";
        echo "<script>window.close();</script>";
    }

    public function delete(Request $request)
    {
    	$data['hashed'] = md5($request->id);
    	echo json_encode($data);
    }

    public function go_delete($hashed_id)
    {
    	$post = DB::select("SELECT id FROM posts where md5(id) = '".$hashed_id."'");

    	$post = Post::find($post[0]->id);

    	$post->delete();
    	
    	echo "<script>window.opener.reloadDatatable();</script>";
        echo "<script>window.close();</script>";
    }
}
