@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$title}} Comment</div>
                <div class="card-body">              
                    <form action="{{url('/comment/store', empty($comment) ? '' : $comment->id)}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Comment For <b>{{$post->name}}</b></label>
                            <textarea autocomplete="off" class="form-control" name="content">{{empty($comment) ? '' : $comment->content}}</textarea>
                            @if($errors->has('content'))
                                <small style="color: red !important;" class="form-text text-muted">{{ $errors->first('content') }}</small>
                            @endif
                            <input type="hidden" name="post_id" value="{{$post->id}}">
                        </div>
                        
                        <button type="submit" class="btn btn-success">Submit</button>

                        <a href="{{url('/landing/detail', $post->id)}}" class="btn btn-secondary">Back</a>
                    </form>
                </div> 
        </div>
    </div>
</div>
</div>
@endsection

