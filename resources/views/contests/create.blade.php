@extends('layouts.app')

@section('content')
    <div class="col-md-6 no-padding-col">
        <h2>Create Contest</h2>

        @if (count($errors) > 0)
            <div>
                <ul class="error list-no-indent">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form role="form" method="POST" action="{{ route('contests.store') }}" id="createForm">
            {{ csrf_field() }}

            <div class="form-group">
                <label for="contestName">Name</label>
                <input type="text" class="form-control" id="contestName" name="contestName" value="{{ old('contestName', 'RobLeg 2018') }}" required/>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <button id="submitBtn" type="submit" class="btn btn-block btn-default">Create</button>
                </div>
            </div>
        </form>
    </div>
@endsection
