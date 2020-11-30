@extends('admin.AdminHome')

@section('content')
@foreach($aproved_news as $aproved_new)
<form action="{{ route('AdminAprovedShowNews', ['id'=>$aproved_new->id]) }}" method="post">
    @csrf
    <div class="container">
        <div class="card mb-3" style="max-width: 540px;">
        <div class="row no-gutters">
            <div class="col-md-4">
            <img src="{{ asset('images'."/".$aproved_new->image) }}" alt="" style="with:100px; height:80px" class="img-circle">
            </div>
            <div class="col-md-8">
            <div class="card-body">
                <div class="card-header">
                <a href="{{ route('AdminAprovedShowNews', ['id'=>$aproved_new->id]) }}" class="btn btn-secondary btn-lg btn-block"><h5 class="card-title" style="background-color="grey">{{ $aproved_new->title }}</h5></a>
                </div>
                <p class="card-text"> {{ $aproved_new->short_description }} </p>
                <p class="card-text"><small class="text-muted"> {{ $aproved_new->created_at }} </small></p>
            </div>
            </div>
        </div>
        </div>
        </div>
        <hr/>
</form>
@endforeach
@endsection