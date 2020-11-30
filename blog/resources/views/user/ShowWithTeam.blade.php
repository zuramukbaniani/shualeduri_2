@extends('user.UserHome')

@section('content')
@foreach($news as $new)
<div class="container">
        <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <img src="{{ asset('images'."/".$new->image) }}" alt="" style="with:100px; height:100px" class="img-circle">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <div class="card-header">
                    <a href="{{ route('ShowPost', ['id'=>$new->id ]) }}" class="btn btn-secondary btn-lg btn-block">{{ $new->title }}</a>
                <small>
                    <a href="{{ route('UserSeeUser', ['id'=>$new->user_id]) }}" class="mr-2"> ავტორი: {{ $new->username }}</a>
                </small>
                </div>
                <p class="card-text"> {{ $new->short_description }} </p>
                <p class="card-text"><small class="text-muted"> {{ $new->created_at }} </small></p>
            </div>
            </div>
        </div>
        </div>
        </div>
        <hr/>
@endforeach
<div class="container">
    {{ $news->links() }}
</div>
@endsection