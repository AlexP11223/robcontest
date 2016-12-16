<div class="form-horizontal team-info">
    <div class="form-group">
        <label class="col-md-3">Team members</label>
        <div class="col-md-9">
            @foreach($team->members as $member)
                <div>
                    {{ $member->first_name }} {{ $member->last_name }}, {{ $member->age() }}
                </div>
            @endforeach
        </div>
    </div>
    @if($team->school)
        <div class="form-group">
            <label class="col-md-3">School</label>
            <div class="col-md-9">
                <div>
                    {{ $team->school }}
                </div>
            </div>
        </div>
    @endif
    <div class="form-group">
        <label class="col-md-3">Teacher or <br/>accompanying adult</label>
        <div class="col-md-9">
            <div>
                {{ $team->teacher_first_name }} {{ $team->teacher_last_name }}
            </div>
        </div>
    </div>
    @if($showPrivateInfo)
        <div class="form-group">
            <label class="col-md-3">Contact information</label>
            <div class="col-md-9">
                <div>
                    {{ $team->email }}
                </div>
                <div>
                    {{ $team->phone }}
                </div>
            </div>
        </div>
    @endif
    <div class="form-group">
        <label class="col-md-3">Competitions</label>
        <div class="col-md-9">
            <ul class="list-no-indent">
                @if($team->sumo)
                    <li>Sumo</li>
                @endif
                @if($team->obstacles)
                    <li>Obstacles course</li>
                @endif
            </ul>
        </div>
    </div>
</div>
