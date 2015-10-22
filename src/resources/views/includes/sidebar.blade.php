@section("sidebar")

<div class="sidebar">
    <div class="sidebar_content">
        <ul class="sidebar__navigation">
            <li>
                <a class="link--text" href="/admin/dashboard">Dashboard</a>
            </li>
            @if(\SidneyDobber\User\AEUser::authorize('users'))
                <li>
                    <a class="link--text" href="/admin/users">Users</a>
                </li>
                <li>
                    <a class="link--text" href="/admin/users/add">Add user</a>
                </li>
            @endif
        </ul>
    </div>
</div>

@show