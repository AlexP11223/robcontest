<div class="form-horizontal team-info">
    <div class="form-group">
        <label class="col-md-3">Team members</label>
        <div class="col-md-9">
            @foreach($team->members as $member)
                <div>
                    {{ $member->first_name }} {{ $member->last_name }}, {{ $member->age() }} ({{ $member->dob->format('Y-m-d') }})
                </div>
            @endforeach
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3">School</label>
        <div class="col-md-9">
            <div>
                {{ $team->school }}
            </div>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-3">Teacher or <br/>accompanying adult</label>
        <div class="col-md-9">
            <div>
                {{ $team->teacher_first_name }} {{ $team->teacher_last_name }}
            </div>
        </div>
    </div>
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
</div>
