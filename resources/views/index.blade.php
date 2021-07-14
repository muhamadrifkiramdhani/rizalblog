@extends('layouts.main')

@section('content')
    <h1>Belum dipublish</h1>
    @foreach($data as $record)
        <?php if($record->published_at == null):?>
        <div class="my-3">
            <h2 class="m-0 p-0"><a href="{{url('/articles/' . $record->id)}}">{{$record->title}}</a></h2>
            <div>
                <a href="{{url('/articles/update/' . $record->id)}}" type="button" class="btn btn-secondary btn-lg active" role="button" aria-pressed="true">Update</a>
                <a href="{{url('/articles/delete/' . $record->id)}}" type="button" class="btn btn-warning btn-lg active" role="button" aria-pressed="true" onclick="return confirm('yakin ingin menghapus arikel ini?')">Delete</a>
                <a href="{{url('/articles/publish/' . $record->id)}}" type="button" class="btn btn-primary btn-lg active" role="button" aria-pressed="true" onclick="return confirm('ingin mempublish arikel ini?')">Publish</a>
            </div>
            <p class="m-0 p-0">Author by at: {{$record->author}}</p>   
            <p class="m-0 p-0">Written at: {{$record->created_at}}</p>   
        </div>
        <?php endif; ?>
    @endforeach
    <h1>Sudah dipublish</h1>
    @foreach($data as $record)
        <?php if($record->published_at !== null):?>
        <div class="my-3">
            <h2 class="m-0 p-0"><a href="{{url('/articles/' . $record->id)}}">{{$record->title}}</a></h2>
            <div>
                <a href="{{url('/articles/update/' . $record->id)}}" type="button" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Update</a>
                <a href="{{url('/articles/delete/' . $record->id)}}" type="button" class="btn btn-warning btn-lg active" role="button" aria-pressed="true" onclick="return confirm('yakin ingin menghapus arikel ini?')">Delete</a>
            </div>
            <p class="m-0 p-0">Author by at: {{$record->author}}</p>   
            <p class="m-0 p-0">Written at: {{$record->created_at}}</p>   
        </div>
        <?php endif; ?>
    @endforeach
@endsection
