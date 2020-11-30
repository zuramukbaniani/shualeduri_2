@extends('user.UserHome')

@section('content')
<div class="container">
    <h1>აირჩიეთ გუნდი, რომელზეც გსურთ სიახლის დამატება</h1>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>გუნდები</th>
            </tr>
    @foreach($teams as $team)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <form action="{{ route('UserAddNews') }}" method="POST">
                @csrf
                    <input type="hidden" name="id" value="{{ $team->id }}">
                    <td><button class="btn btn-info mt-2">{{ $team->team }}</button></td>
                </form>
            </tr>
            @endforeach
        </table>
</div>
@endsection