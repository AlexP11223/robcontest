@extends('layouts.app')

@section('content')
    <h2>{{ $contest->name }}</h2>

    <div>
        <a class="lead dotted-link" href="javascript:void(0)" id="teamsBtn">Teams</a>

        <div id="teams" style="display:none;">
            @foreach($teams as $team)
                <div class="list-group-item">
                    <div class="row">
                        <div class="col-xs-12">
                            <h4>{{$team->name}}</h4>
                        </div>
                    </div>

                    @include('contests.teams.info', ['showPrivateInfo' => false])
                </div>
            @endforeach
        </div>
    </div>

    <script src="/js/contest.js"></script>
@endsection
