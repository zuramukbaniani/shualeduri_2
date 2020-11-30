@extends('admin.AdminHome')

@section('content')
<div class="container">
<form action="{{ route('AdminDeleteApprovedPost') }}" method="post">
@csrf
        <div class="card">
            <div class="card-body">
            <img src="{{ asset('images'."/".$new->image) }}" alt="">
                <h4>{{ $new->title }}</h4>
                <p>{{ $new->short_description }}</p>
                <article>{{ $new->description }}</article>
                <input type="hidden" name="id" value="{{ $new->id }}">
                <button class="btn btn-danger">წაშლა</button>
            </div>
        </div>
</form>
<form action="{{ route('AdminAproved') }}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{ $new->id }}">
    <input type="hidden" name="team_id" value="{{ $new->team_id }}">
    <input type="hidden" name="league_id" value="{{ $new->league_id }}">
    <input type="hidden" name="title" value="{{ $new->title }}">
    <input type="hidden" name="short_description" value="{{ $new->short_description }}">
    <input type="hidden" name="description" value="{{ $new->description }}">
    <input type="hidden" name="image_name" value="{{ $new->image }}">
    <input type="hidden" name="user_id" value="{{ $new->user_id }}">
    <input type="hidden" name="username" value="{{ $new->username }}">
    <button class="btn btn-success">დადასტურება</button>
</form>
<form action="{{ route('UpdateBlade', ['id'=>$new->id]) }}" method="post">
    @csrf
    <a class="btn btn-info" href="{{ route('UpdateBlade', ['id'=>$new->id]) }}">რედაქტირება</a>
</form>
</div>
@endsection