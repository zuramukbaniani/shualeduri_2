@extends('admin.AdminHome')

@section('content')
<div class="container">
    <h1>ჩემპიონატები</h1>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>ჩემპიონატი</th>
            </tr>
    @foreach($leagues as $league)
            <tr>
                <td>{{ $league->id }}</td>
                <form action="{{ route('AdminShowTeams', ['id'=>$league->id]) }}" method="POST">
                    <td><a class="btn btn-info mt-2" href="{{ route('AdminShowTeams', ['id'=>$league->id]) }}">{{ $league->leagues }}</a></td>
                </form>
            </tr>
            @endforeach
        </table>
    <div>
        <form action="{{ route('SaveLeague') }}" method="POST">
            @csrf
            <p>დამატება</p>
            <input type="text" name="league">
            <button class="btn btn-primary mt-2">დამატება</button>
        </form>
    </div>
</div>
@endsection