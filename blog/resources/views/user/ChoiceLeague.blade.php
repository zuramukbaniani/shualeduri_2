@extends('user.UserHome')

@section('content')
<div class="container">
    <h1>აირჩიეთ ჩემპიონატი, რომელზეც გსურთ სიახლის დამატება</h1>
        <table class="table table-bordered">
            <tr>
                <th>#</th>
                <th>ჩემპიონატი</th>
            </tr>
    @foreach($leagues as $league)
            <tr>
                <td>{{ $league->id }}</td>
                <form action="{{ route('UserChoiceTeam', ['id'=>$league->id]) }}" method="POST">
                    <td><a class="btn btn-info mt-2" href="{{ route('UserChoiceTeam', ['id'=>$league->id]) }}">{{ $league->leagues }}</a></td>
                </form>
            </tr>
            @endforeach
        </table>
</div>
@endsection