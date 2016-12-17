<div class="user-menu">
    <div class="user-menu-item">
        <a href="{{ url('/info') }}" role="button" class="btn btn-primary btn-block">
            <span class="glyphicon glyphicon-info-sign"></span>
            Information
        </a>
    </div>
    @php($currentContest = \App\Models\Contest::current())
    @if (isset($currentContest) && !$currentContest->registration_finished)
        <div class="user-menu-item">
            <a href="{{ route('apply') }}" role="button" class="btn btn-primary btn-block">
                <span class="glyphicon glyphicon-file"></span>
                Apply
            </a>
        </div>
    @endif

    @if (Auth::check())
        @if (Auth::user()->hasRole('admin'))
            <div id="adminMenu">
                @if (isset($currentContest))
                    <div class="user-menu-item">
                        <a href="{{ route('review-teams', [$currentContest->urlSlug]) }}" role="button" class="btn btn-primary btn-block">
                            <span class="glyphicon glyphicon-check"></span>
                            Review teams
                        </a>
                    </div>
                @endif
                <div class="user-menu-item">
                    <a href="{{ route('posts.create') }}" role="button" class="btn btn-primary btn-block">
                        <span class="glyphicon glyphicon-pencil"></span>
                        Add post
                    </a>
                </div>
                    <div class="user-menu-item">
                        <a href="{{ route('contests.create') }}" role="button" class="btn btn-primary btn-block">
                            <span class="glyphicon glyphicon-plus"></span>
                            Create contest
                        </a>
                    </div>
            </div>
        @endif

        <div class="user-menu-item">
            <strong>{{ Auth::user()->name }}</strong>

            <div>
                <a href="{{ route('change-password') }}" role="button">
                    Change password
                </a>
            </div>

            <div>
                <form action="{{ route('logout') }}" class="logout-form" method="post">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-link">Logout</button>
                </form>
            </div>
        </div>
    @endif
</div>