@extends("user::masters.admin")

@section("content")

<h2>Users</h2>

<!-- Messages. -->
@if($successes)
    <ul class="message message-success">
    @foreach ($successes as $success)
        <li>{!! $success !!}</li>
    @endforeach
    </ul>
@endif

<table class="item">
    <thead>
        <tr>
            <th>Username</th>
            <th>E-mail</th>
            <th>User role</th>
        </tr>
    </thead>
    <tbody>
    @if($users)
        @foreach($users as $user)
            <tr>
                <td>
                    <a href="/admin/users/{{ $user->id }}" class="bold">{{ $user->username }}</a>
                    <div class="crud_wrapper">
                        <a href="/admin/users/{{ $user->id }}">Edit</a>
                        @if($user->userrole != 'superuser' && $userrole < 2)
                            | <a href="/admin/users/{{ $user->id }}/delete">Delete</a>
                        @endif
                    </div>
                </td>
                <td>
                    <a href="mailto:{{ $user->email }}" title="Email: {{ $user->email }}">{{ $user->email }}</a>
                </td>
                <td>
                    <span>{{ $user->userrole }}</span>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2">There are no users to display.</td>
        </tr>
    @endif
    </tbody>
</table>

@stop