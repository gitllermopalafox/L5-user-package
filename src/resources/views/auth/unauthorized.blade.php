@extends("user::masters.public")

@section("content")

<div class="modal modal-small">

    <ul class="alert alert-status">
        <li>
            <h3>You are not authorized to access this content</h3>
            <p>This page is excluded by the system administrator. Your current role does not allow you to view the requested page.</p>
        </li>
    </ul>
</div>

@stop
