@extends('admin.AdminHome')

@section('content')
@foreach($news as $new)
<div class="container">
<div class="card mb-3" style="max-width: 540px;">
  <div class="row no-gutters">
    <div class="col-md-4">
    <img src="{{ asset('images'."/".$new->image) }}" alt="" style="with:100px; height:80px" class="img-circle">
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <div class="card-header">
          <a href="{{ route('AdminShowNews', ['id'=>$new->id]) }}" class="btn btn-secondary btn-lg btn-block"><h5 class="card-title" style="background-color="grey">{{ $new->title }}</h5></a>
          <form action="{{ route('AdminDeleteAprovedPost') }}" method="post">
            @csrf
            <input type="hidden" name="news_id" value="{{ $new->id }}">
            <button class="btn btn-danger btn-lg btn-block"><h5 class="card-title" style="background-color="grey">წაშლა</h5></button>
          </form>
        </div>
        <a href="{{ route('AdminSeeUser',['id' => $new->user_id]) }}">ავტორი {{ $new->username }}</a>
        <p class="card-text"> {{ $new->short_description }} </p>
        <p class="card-text"><small class="text-muted"> {{ $new->created_at }} </small></p>
      </div>
    </div>
  </div>
</div>
</div>
<hr/>
@endforeach
    </div>
    <div class="container">
        {{ $news->links() }}
    </div>
@endsection