@extends('user.UserHome')

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
      @if(Auth::user()->id === $comment->user_id || Auth::user()->id == $comment->post_own_id)
        <a href="{{ route('UserDeleteComments', ['id'=>$comment->id]) }}"><i class="fas fa-trash-alt">წაშლა</i></a>
      @endif
      @if(Auth::user()->id === $comment->user_id)
        <a href="#" onclick="update({{ $comment->id }}, '{{ $comment->comment }}')"><i class="fas fa-edit">რედაქტირება</i></a>
      @endif
        <a href="#" onclick="ChangeDisplay({{ $comment->id }})"><i class="fas fa-reply">პასუხი</i></a>
        <form action="{{ route('UserReplyComments') }}" method="post">
            @csrf
            <div style="display:none" id="reply-{{ $comment->id }}">
                <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                <input type="hidden" name="mather_comment_id" value="{{ $comment->id }}">
                <input type="hidden" name="post_id" value="{{ $news->id }}">
                <input type="hidden" name="post_owner_id" value="{{ $news->user_id }}">
                <input type="hidden" name="user_id" value="{{ $news->user_id }}">
                <input type="text" name="reply_comment" class="form-control" value="{{ $comment->username }} ">
                <button class="btn btn-primary">პასუხი</button>
            </div>
            <script>
                function ChangeDisplay(name){
                    document.getElementById('reply-' + name).style.display = 'block';
                }
                function update(id, comment){
                      document.getElementById("update").value = comment;
                      document.getElementById("comments").action = '{{ route('UserUpdateComments') }}';
                      document.getElementById("comment_id").value = id;
                    }
            </script>   
        </form>
      @foreach($replyComments as $replyComment)
        @if($replyComment->comment_id === $comment->id || $replyComment->mather_comment_id === $comment->id)
          <div class="media">
            <div class="media-left">
                <img src="{{ asset('images/user.png') }}" alt="" style="with:60px; height:60px" class="img-circle">
            </div>
            <div class="media-body">
              <h4 class="media-heading">{{ $replyComment->username }}</h4>
              <p>{{ $replyComment->comment }}</p>
            @if(Auth::user()->id === $replyComment->user_id || Auth::user()->id === $replyComment->post_own_id) 
              <a href="{{ route('UserDeleteReplyComments', ['id'=>$replyComment->id]) }}"><i class="fas fa-trash-alt">წაშლა</i></a>
            @endif
            <a href="#" onclick="updateReply({{ $replyComment->id }}, '{{ $replyComment->comment }}')">
            <i class="fas fa-edit">რედაქტირება</i></a>
            <a href="#" onclick="ChangeDisplay({{ $replyComment->id }})"><i class="fas fa-reply">პასუხი</i></a>
            <form action="{{ route('UserReplyComments') }}" id="update_reply_comments-{{ $replyComment->id }}" method="post">
                @csrf
                <div style="display:none" id="reply-{{ $replyComment->id }}">
                    <input type="hidden" id="id-{{ $replyComment->id }}" name="id-{{ $replyComment->id }}">
                    <input type="hidden" name="mather_comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    <input type="hidden" name="post_id" value="{{ $news->id }}">
                    <input type="hidden" name="post_owner_id" value="{{ $news->user_id }}">
                    <input type="hidden" name="user_id" value="{{ $news->user_id }}">
                    <input type="text" id="reply_comment_input-{{ $replyComment->id }}" name="reply_comment" class="form-control" value="{{ $comment->username }} ">
                    <button class="btn btn-primary">პასუხი</button>
                </div>
                <script>
                    function ChangeDisplay(name){
                        document.getElementById('reply-' + name).style.display = 'block';
                    }
                    function updateReply(id, comment){
                        document.getElementById('reply-' + id).style.display = 'block';
                        document.getElementById('reply_comment_input-' + id).value = comment;
                        document.getElementById("update_reply_comments-" + id).action = '{{ route('UserUpdateReplyComments') }}';
                        document.getElementById("id-" + id).value = id;
                        document.getElementById("id-" + id).setAttribute("name", "id");
                    }
                </script>   
            </form>
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
<div class="container">
    <form action="{{ route('comments') }}" id="comments" method="post">
        @csrf
        <h4>კომენტარის დამატება</h4>
        <input type="hidden" name="comment_id" id="comment_id">
        <input type="hidden" name="post_id" value="{{ $news->id }}">
        <input type="hidden" name="post_owner_id" value="{{ $news->user_id }}">
        <input type="hidden" name="user_id" value="{{ $news->user_id }}">
        <textarea id="update" name="comment" class="form-control" cols="30" rows="10" placeholder="კომენტარი"></textarea>
        <button class="btn btn-primary">დამატება</button>
    </form>
</div>
@endsection