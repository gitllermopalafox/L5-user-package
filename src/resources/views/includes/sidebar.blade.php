@section("sidebar")

<div id="sidebar">
    <div id="sidebar_content">
        <ul class="sidebar__navigation">
            <li><a href="/admin/dashboard">Dashboard</a></li>
            @if(\SidneyDobber\User\AEUser::authorize('users'))
                <li><a href="/admin/users">Users</a></li>
                <li><a href="/admin/users/add">Add user</a></li>
            @endif
        </ul>
    </div>
</div>

@show