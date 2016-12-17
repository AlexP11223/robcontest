@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="/jquery/jquery.bracket.min.css"/>

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

    <div id="sumo">
        <h3>Sumo</h3>

        <div id="sumoTree"></div>

    </div>

    <div class="row" id="obstacles">
        <div class="col-md-7">
            <h3>Obstacles</h3>
            <table class="table table-bordered table-fluid" id="obstaclesRoundTable">
                <tbody>
                </tbody>
            </table>

        </div>
    </div>

    <script>
        window.contestId = '{{ $contest->urlSlug }}';
    </script>

    <script src="/js/contest.js"></script>
@endsection
