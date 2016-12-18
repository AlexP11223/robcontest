@foreach($contest->currentSumoRound() as $sumoGame)
    @if($sumoGame->team2)
        <form class="form-horizontal sumo-form" method="post" action="{{ route('set-sumo-result', [$sumoGame->id]) }}">
            {{ csrf_field() }}
            {{ method_field('put') }}
            <div class="form-group sumo-round-input">
                <div class="col-sm-4">
                    <label class="radio-inline">
                        <input type="radio" name="winner" value="1" required/>{{ $sumoGame->team1->name }}
                    </label>
                </div>
                <div class="col-sm-4">
                    <label class="radio-inline">
                        <input type="radio" name="winner" value="2" required/>{{ $sumoGame->team2->name }}
                    </label>
                </div>

                <div class="col-sm-4">
                    <button type="submit" class="btn btn-default">Set result</button>
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
    @endif
@endforeach
