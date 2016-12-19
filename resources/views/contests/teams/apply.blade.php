@extends('layouts.app')

@section('content')

    <link rel="stylesheet" href="/jquery/jquery-ui.min.css" xmlns="http://www.w3.org/1999/html"/>
    <link rel="stylesheet" href="/jquery/jquery-ui.theme.min.css"/>

    <div class="col-md-5 no-padding-col">
        <h2>Apply for contest</h2>

        @if (session('success'))
            <div class="success-confirmation">
                <img width="32" height="32" src="/img/success-tick.png"/>
                <div>Your application request was submitted. It will be reviewed by administrators and you will receive email.</div>
            </div>
        @else
            <form method="post" action="{{ route('apply') }}" id="applyForm">
                {{ csrf_field() }}

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

                <div class="form-group">
                    <label for="team">Team name</label>
                    <input type="text" class="form-control" id="team" name="team" value="{{ old('team') }}" />
                </div>
                <div class="form-group">
                    <label for="school">School</label>
                    <input type="text" class="form-control" id="school" name="school" value="{{ old('school') }}" />
                </div>
                <div class="form-group">
                    <label>Team members</label>
                    <ol>
                        <li>
                            <br/>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="member1_first_name">First name</label>
                                    <input type="text" class="form-control" id="member1_first_name" name="member1_first_name" value="{{ old('member1_first_name') }}" />
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="member1_last_name">Last name</label>
                                    <input type="text" class="form-control" id="member1_last_name" name="member1_last_name" value="{{ old('member1_last_name') }}" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="member1_dob">Date of birth</label>
                                    <input type="text" class="form-control" id="member1_dob" name="member1_dob" placeholder="YYYY-MM-DD" value="{{ old('member1_dob') }}" />
                                </div>
                            </div>
                        </li>
                        <li>
                            <br/>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="member2_first_name">First name</label>
                                    <input type="text" class="form-control" id="member2_first_name" name="member2_first_name" value="{{ old('member2_first_name') }}" />
                                </div>
                                <div class="form-group col-xs-6">
                                    <label for="member2_last_name">Last name</label>
                                    <input type="text" class="form-control" id="member2_last_name" name="member2_last_name" value="{{ old('member2_last_name') }}" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-xs-6">
                                    <label for="member2_dob">Date of birth</label>
                                    <input type="text" class="form-control" id="member2_dob" name="member2_dob" placeholder="YYYY-MM-DD" value="{{ old('member2_dob') }}" />
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>

                <label>Teacher or accompanying adult</label>
                <div class="input-section">
                    <div class="row">
                        <div class="form-group col-xs-6">
                            <label for="teacher_first_name">First name</label>
                            <input type="text" class="form-control" id="teacher_first_name" name="teacher_first_name" value="{{ old('teacher_first_name') }}" />
                        </div>
                        <div class="form-group col-xs-6">
                            <label for="teacher_last_name">Last name</label>
                            <input type="text" class="form-control" id="teacher_last_name" name="teacher_last_name" value="{{ old('teacher_last_name') }}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" />
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input  type="text" pattern="[0-9]*" class="form-control phone-input" id="phone" name="phone" value="{{ old('phone', '370') }}" />
                    </div>
                </div>

                <div class="form-group competition-choice-group">
                    <label>Participate in</label>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="sumo" class="competition-choice" @if(old('sumo')) checked @endif>Sumo
                        </label>
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="obstacles" class="competition-choice" @if(old('obstacles')) checked @endif>Obstacles
                        </label>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <button type="submit" class="btn btn-default btn-block">Submit</button>
                    </div>
                </div>

            </form>
        @endif
    </div>

    <script src="/js/apply.js"></script>

@endsection
