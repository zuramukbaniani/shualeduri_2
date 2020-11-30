@extends('admin.AdminHome')

@section('content')
<div class="container">
    <div class="text-content">
        <img src="{{ asset('images')."/".$news->image }}" style="margin-left:20%; with:100%; height:300px">
        <h2 style="text-align:center">{{ $news->title }}</h2>
        <p style="text-align:center">{{ $news->short_description }}</p><br>
        <p style="text-align:center">{{ $news->description }}</p><br>
    </div>
    <form action="{{ route('AdminAddComment') }}" method="post">
        @csrf
        <h4>კომენტარის დამატება</h4>
        <input type="hidden" name="post_id" value="{{ $news->id }}">
        <input type="hidden" name="post_owner_id" value="{{ $news->user_id }}">
        <input type="hidden" name="user_id" value="{{ $news->user_id }}">
        <textarea name="comment" class="form-control" cols="30" rows="10" placeholder="კომენტარი">{{ $news->georgia }}</textarea>
        <button class="btn btn-primary">დამატება</button>
    </form>
</div>
@endsection