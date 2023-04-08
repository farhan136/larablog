<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

    public function form($id = '', $id2 = '', $module = '')
    {
    	if($id2 == ''){
    		$title = 'Create';
    	}else{
    		$title = 'Edit';
    	}
    	$post = Post::find($id);
        $comment = Comment::find($id2);
        
        $data = array(
        	'post'=>$post,
            'comment'=>$comment,
            'module'=>$module,
            'title'=>$title
        );
        if($id2 != ''){
            if($comment->author != Auth::user()->id){
                return redirect('landing/detail/'. $id)   ;
            }
        }
        
        return view('comment.form', $data);
    }

    public function store(Request $request, $id = '')
    {
    	$request->validate([
		    'content' => 'required',
		]);

        if($id == ''){
           	$comment = new Comment;
           	$comment->content = $request->content;
           	$comment->author = Auth::user()->id;
           	$comment->post_id = $request->post_id;
           	$comment->save();
        }else{
            $comment = Comment::find($id);
            $comment->content = $request->content;


            $comment->save();
        }

        return redirect('/landing/detail/'.$request->post_id);
    }

    public function delete($id = '', $id2 = '')
    {
        $comment = Comment::find($id2);
        $comment->is_deleted = 1;
        $comment->save();

        return redirect('/landing/detail/'.$id);
    }
}
