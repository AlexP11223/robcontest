@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="/jquery/jquery-ui.min.css" xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="/jquery/jquery-ui.theme.min.css"/>

    <div class="col-md-10 no-padding-col">
        <h2>Review teams for {{ $contest->name }}</h2>

        <div class="list-group" id="teamsList">
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
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script src="/js/reviewteams.js"></script>
@endsection
