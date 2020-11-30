@extends('layout')

@section('content')
<div class="container">
    <div class="text-content">
        <img src="{{ asset('images')."/".$news->image }}" style="margin-left:20%; with:100%; height:300px">
        <h2 style="text-align:center">{{ $news->title }}</h2>
        <p style="text-align:center">{{ $news->short_description }}</p><br>
        <p style="text-align:center">{{ $news->description }}</p><br>
    </div>
  @foreach($comments as $comment)
  <div class="media">
    <div class="media-left">
        <img src="{{ asset('images/user.png') }}" alt="" style="with:60px; height:60px" class="img-circle">
    </div>
    <div class="media-body">
      <h4 class="media-heading">{{ $comment->username }}</h4>
      <p>{{ $comment->comment }}</p>
      @foreach($replyComments as $replyComment)
        @if($replyComment->comment_id === $comment->id || $replyComment->mather_comment_id === $comment->id)
          <div class="media">
            <div class="media-left">
                <img src="{{ asset('images/user.png') }}" alt="" style="with:60px; height:60px" class="img-circle">
            </div>
            <div class="media-body">
              <h4 class="media-heading">{{ $replyComment->username }}</h4>
              <p>{{ $replyComment->comment }}</p>
              
            </div>
          </div>
          @endif
          @endforeach
        </div>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection