@extends('base')

@section('title')
Matchs joués par l'équipe
@endsection


@section('content')
    <a class="btn btn-primary" href="{{ route('teams.follow', ['teamId'=>$rankingRow['team_id']]) }}">Suivre</a><br><br>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th>N°</th>
                <th>Équipe</th>
                <th>MJ</th>
                <th>G</th>
                <th>N</th>
                <th>P</th>
                <th>BP</th>
                <th>BC</th>
                <th>DB</th>
                <th>PTS</th>
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $rankingRow['rank'] }}</td>
                    <td><a href="{{route('teams.show', ['teamId'=>$rankingRow['team_id']])}}">
                        {{ $rankingRow['name'] }}</a>
                    </td>
                    
                    <td>{{ $rankingRow['match_played_count'] }}</td>
                    <td>{{ $rankingRow['match_won_count'] }}</td>
                    <td>{{ $rankingRow['draw_count'] }}</td>
                    <td>{{ $rankingRow['match_lost_count'] }}</td>
                    <td>{{ $rankingRow['goal_for_count'] }}</td>
                    <td>{{ $rankingRow['goal_against_count'] }}</td>
                    <td>{{ $rankingRow['goal_difference'] }}</td>
                    <td>{{ $rankingRow['points'] }}</td>
                </tr>
        </tbody>
    </table>

    <table class="table table-striped">

        @foreach ($teamMatches as $teamMatch)
        <form action="/matches/{{$teamMatch['id']}}/delete" method="POST">
            <tr>
                @if (session()->has('user'))
                <td>
                        @csrf
                        <button class="btn btn-danger" type="submit">Supprimer</button>    
                </td> 
                @endif

                <td>{{$teamMatch['m_date']}}</td>
                
                <td> <a href="{{route('ranking.show', ['teamId'=>$teamMatch['id']])}}">
                    {{$teamMatch['name0']}}</a>
                </td>

                <td>{{$teamMatch['score0']}}</td>
                <td>-</td>
                <td>{{$teamMatch['score1']}}</td>

                <td><a href="{{route('ranking.show', ['teamId'=>$teamMatch['id']])}}">
                    {{$teamMatch['name1']}}</a>
                </td>
                
            </tr>
        </form>          
        @endforeach

    </table>
@endsection