@extends('layouts.layout_form')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{$title}} Content</div>
                <div class="card-body">              
                    <form action="{{url('/post/store', empty($post) ? '' : $post->id)}}" method="post">
                        @csrf

                        @if($module == 'detail')
                        <div class="mb-3">
                            <label for="name" class="form-label">Author</label>
                            <input type="text" class="form-control" readonly autocomplete="off" value="{{empty($post) ? '' : $post->user->name}}">
                        </div>
                        @endif
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control"  {{$module == 'detail' ? 'readonly' : ''}} autocomplete="off" name="name" value="{{empty($post) ? '' : $post->name}}">
                            @if($errors->has('name'))
                                <small style="color: red !important;" class=" form-text text-muted">{{ $errors->first('name') }}</small >
                            @endif
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Content</label>
                            <textarea autocomplete="off" {{$module == 'detail' ? 'readonly' : ''}} class="form-control" name="description">{{empty($post) ? '' : $post->description}}</textarea>
                            @if($errors->has('description'))
                                <small style="color: red !important;" class="form-text text-muted">{{ $errors->first('description') }}</small>
                            @endif
                        </div>
                        @if($module == 'detail')
                        <div class="mb-3">
                            <label for="name" class="form-label">Published At</label>
                            <input type="text" class="form-control" readonly autocomplete="off" value="{{$post->created_at->format('Y-M-d')}}">
                        </div>
                        @else
                        <button type="submit" class="btn btn-success">Submit</button>
                        @endif
                        
                    </form>
                </div> 
        </div>
    </div>
</div>
</div>
@endsection

