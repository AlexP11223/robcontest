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

    @if (Auth::check() && Auth::user()->hasRole('admin'))
        <div class="row">
            <div class="col-md-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Set results</div>
                    <div class="panel-body" id="sumoFormPanel">
                        @include('contests.sumoform')
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        <div class="col-md-7">
            <h3>Obstacles</h3>
            <table class="table table-bordered table-fluid" id="obstaclesRoundTable">
                <tbody>
                </tbody>
            </table>
        </div>
    </div>

    @if (Auth::check() && Auth::user()->hasRole('admin'))
        <div class="row">
            <div class="col-md-7">
                <div class="panel panel-default">
                    <div class="panel-heading">Set results</div>
                    <div class="panel-body">
                        @foreach($contest->obstaclesGames as $obstaclesGame)
                            <form class="form-horizontal obstacles-form" method="post" action="{{ route('set-obstacles-result', [$obstaclesGame->id]) }}">
                                {{ csrf_field() }}
                                {{ method_field('put') }}
                                <div class="form-group">
                                    <label class="col-sm-4 control-label">{{$obstaclesGame->team->name}}</label>
                                    <div class="col-sm-3">
                                        <input type="number" class="form-control score" name="time" placeholder="0.0" required step="0.01" min="0"/>
                                    </div>
                                    <div class="col-sm-3">
                                        <button type="submit" class="btn btn-default">Set time</button>
                                    </div>

                                    <div>
                                        <label class="error request-error" style="display: none"></label>
                                    </div>

                                    <div>
                                        <div class="loading-indicator" style="display: none">
                                            <img width="16" height="16" src="/img/ajax-loader.gif"/>
                                            Sending request...
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        window.contestId = '{{ $contest->urlSlug }}';
    </script>
    @if (Auth::check() && Auth::user()->hasRole('admin'))
        <script src="/js/contestedit.js"></script>
    @else
        <script src="/js/contest.js"></script>
    @endif
@endsection
