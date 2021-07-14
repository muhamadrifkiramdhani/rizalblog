@extends('layouts.main')
@section('title', 'Update Article')

@section('content')
 <h2 class="m-5">Update Article</h2>
 <form method="post">
    @csrf
    <div class="mb-3">
        <label for="frm-title" class="form-label">Title</label>
        <input type="text" class="form-control" id="frm-title" name="frm-title" placeholder="Article Title" value="{{$data->title}}">
    </div>
    <input type="hidden" id="frm-author" name="frm-author" id="hiddenField" value="{{$data->author}}">

    <div class="mb-3">
        <label for="frm-title" class="form-label">Content</label>
        <textarea class="form-control" id="frm-content" name="frm-content" rows="3">{{$data->content}}</textarea>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </div>
 </form>
 @endsection

 @section('page-script')
 @parent
    <script type="text/javascript">
        window.addEventListener('DOMContentLoaded', (event) => {
            tinymce.init({
                selector: 'textarea#frm-content',
                content_css: false,
                skin: false
            });
        });
    </script>
 @endsection