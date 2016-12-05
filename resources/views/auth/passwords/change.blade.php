@extends('layouts.app')

@section('content')
    <div class="col-md-8 col-md-offset-2">
        @if (session('success'))
            <div class="success-confirmation">
                <img width="32" height="32" src="/img/success-tick.png"/>
                <div>Password successfully changed</div>
            </div>
        @endif

        <div class="panel panel-default">
            <div class="panel-heading">Change password</div>
            <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('change-password') }}" id="changePasswordForm">
                    {{ csrf_field() }}

                    @if (count($errors) > 0)
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <ul class="error list-no-indent">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="password" class="col-md-4 control-label">Current password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword" class="col-md-4 control-label">New password</label>

                        <div class="col-md-6">
                            <input id="newPassword" type="password" class="form-control" name="newPassword" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="newPassword_confirmation" class="col-md-4 control-label">Repeat</label>

                        <div class="col-md-6">
                            <input id="newPassword_confirmation" type="password" class="form-control" name="newPassword_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" class="btn btn-primary">
                                Change
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="/js/user.js"></script>

@endsection
