@extends('admin.AdminHome')

@section('content')
<form action="{{ route('AdminAproved') }}" method="post">
    @csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <input type="text" name="title" class="form-control" value="{{ $news->title }}">
                <textarea name="short_description" class="form-control" cols="30" rows="10">{{ $news->short_description }}</textarea>
                <textarea name="description" class="form-control" cols="30" rows="10">{{ $news->description }}</textarea>
                <input type="hidden" name="image_name" value="{{ $news->image }}">
                <input type="hidden" name="team_id" value="{{ $news->team_id }}">
                <input type="hidden" name="league_id" value="{{ $news->league_id }}">
                <input type="hidden" name="id" value="{{ $news->id }}">
                <input type="hidden" name="user_id" value="{{ $news->user_id }}">
                <input type="hidden" name="username" value="{{ $news->username }}">
                <button class="btn btn-primary">განახლება და დადასტურება</button>
            </div>
        </div>
    </div>
</form>
@endsection