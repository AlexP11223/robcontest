@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="/jquery/jquery-ui.min.css" xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="/jquery/jquery-ui.theme.min.css"/>

    <div class="col-md-10 no-padding-col">
        <h2>Review teams for {{ $contest->name }}</h2>

        <div class="list-group" id="teamsList" data-contest-id="{{ $contest->urlSlug }}">
            @foreach($contest->teams as $team)
                <div class="list-group-item team-item" data-id="{{ $team->id }}">
                    <a href="javascript:void(0)" class="team-item-header">
                        <div class="row">
                            <span>{{ $team->name }}</span>
                            <span class="team-status" data-status="{{ $team->statusText() }}">{{ $team->statusText() }}</span>
                        </div>
                    </a>

                    <div class="team-item-content" style="display: none">
                        @include('contests.teams.info')

                        @if(!$contest->isRegistrationFinished)
                            <div class="team-actions">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <button data-action="approveTeam" class="btn btn-block btn-success">Approve</button>
                                    </div>
                                    <div class="col-xs-6">
                                        <button data-action="denyTeam" class="btn btn-block btn-danger">Deny</button>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="loading-indicator" style="display: none">
                                            <img width="16" height="16" src="/img/ajax-loader.gif"/>
                                            Sending request...
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>

        @if(!$contest->isRegistrationFinished)
            <p>
                <a class="lead dotted-link" href="javascript:void(0)" id="startContestShowBtn">Finish registration/start contest</a>
            </p>
            <div id="startContestForm" style="display:none;">
                <form method="post" action="{{ route('start-contest', [$contest->urlSlug]) }}">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}

                    @if (count($errors) > 0)
                        <div class="form-group">
                            <div>
                                <ul class="error list-no-indent">
                                    @foreach (array_unique($errors->all()) as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <div class="col-md-9">
                            <label>Change team order by dragging them in the list below (if needed). Order is important for Sumo pairs.</label>
                            <ul id="teamsOrderableList">
                            </ul>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-default btn-block">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <script src="/js/reviewteams.js"></script>
@endsection
