@extends('admin.AdminHome')

@section('content')
<div class="container">
    <h1>გუნდები</h1>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>წაშლა</th>
                <th>გუნდები</th>
            </tr>
    @foreach($teams as $team)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <form action="{{ route('AdminDeleteTeam') }}" method="POST">
                @csrf
                    <input type="hidden" name="id" value="{{ $team->id }}">
                    <td><button class="btn btn-danger">წაშლა</button></td>
                </form>
                <form action="{{ route('AdminAddNews') }}" method="POST">
                @csrf
                    <input type="hidden" name="id" value="{{ $team->id }}">
                    <td><button class="btn btn-info mt-2">{{ $team->team }}</button></td>
                </form>
            </tr>
            @endforeach
        </table>
    <div>
        <form action="{{ route('AdminAddTeams') }}" method="POST">
            @csrf
            <p>დამატება</p>
            <input type="text" name="team">
            <input type="hidden" value="{{ $team->LeagueId }}" name="league_id">
            <button class="btn btn-primary mt-2">დამატება</button>
        </form>
    </div>
</div>
@endsection