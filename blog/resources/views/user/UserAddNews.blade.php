@extends('user.UserHome')

@section('content')
<form action="{{ route('SavaAdminDatabase') }}" method="POST" enctype="multipart/form-data">
@csrf
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h1 class="mt-2">სიახლის დამატება</h1>
                <p class="text-danger">ამ ველის შევსება სავალდებულოა</p>
                <input type="text" name="title" class="form-control mt-2" placeholder="სათაური">
                <p class="text-danger">ამ ველის შევსება სავალდებულოა</p>
                <input type="file" name="image" class="form-control mt-2" placeholder="ფოტოს დამატება">
                <p class="text-danger">ამ ველის შევსება სავალდებულოა</p>
                <textarea name="short-description" class="form-control mt-2" cols="30" rows="10" placeholder="მოკლე აღწერა"></textarea>
                <p class="text-danger">ამ ველის შევსება სავალდებულოა</p>
                <textarea name="description" class="form-control mt-2" cols="30" rows="10" placeholder="აღწერა"></textarea>
                <input type="hidden" name="id" value="{{ $team->id }}">
                <input type="hidden" name="league_id" value="{{ $team->	LeagueId }}">
                <button class="btn btn-primary">დამატება</button>
            </div>
        </div>
    </div>
</form>
@endsection