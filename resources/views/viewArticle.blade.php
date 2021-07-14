@extends('layouts.main')
@section('title', $data->title)
@section('content')
<?php
if(session()->has('author')){
  $author = session()->get('author');
}
?>
<div>
    <h2 class="m-5 p-0">{{$data->title}}</h2>
    <p class="content p-2">{{$data->content}}</p>
    <p class="content p-2">{{$data->author}}</p>
</div>



<div>
    <div>
        @foreach($comment as $record)
        <?php
        if($data->id == $record->article){
        ?>
        <div class="my-3">
            <p class="m-0 p-0">{{$record->content}}</p>
            <p class="m-0 p-0">Write by: {{$record->author}}</p>   
            <p class="m-0 p-0">Written at: {{$record->created_at}}</p>     
        </div>
        <?php
        }
        ?>
        @endforeach
    </div>
    <form method="post">
    @csrf

    <input type="hidden" id="frm-article" name="frm-article" id="hiddenField" value="{{$data->id}}">
    <input type="hidden" id="frm-author" name="frm-author" id="hiddenField" value="
    <?php
       if(session()->has('author')){
           echo $author;
       } else {
           echo "anonymous";
       }
    ?>">
    <div class="mb-3">
        <label for="frm-title" class="form-label">Content</label>
        <textarea class="form-control" id="frm-content" name="frm-content" rows="3" placeholder="Masukkan Komentar"></textarea>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
 </form>
</div>
    
@endsection