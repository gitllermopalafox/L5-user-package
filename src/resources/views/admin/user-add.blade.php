@extends("user::masters.admin")

@section("content")

<h2>Add user</h2>

<!-- Messages. -->
@if($errors)
    <ul class="alert alert-error">
    @foreach ($errors as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
@endif

<!-- Form. -->
<form method="post">
    {!! csrf_field() !!}
    <div class="form_item">
        <label for="username">Username <span>(Can not be changed)</span></label>
        <input class="text_input" name="username" type="text" value="{{ Input::old('username') }}">
    </div>
    <div class="form_item">
        <label for="email">Email</label>
        <input class="text_input" name="email" type="text" value="{{ Input::old('email') }}">
    </div>
    <div class="form_item">
        <label for="userrole">Userrole</label>
        <select name="userrole" id="userrole">
            @foreach($userroles as $key => $value)
                @if($key == Input::old('userrole'))
                    <option {{ 'selected' }}>{{ $key }}</option>
                @else
                    <option>{{ $key }}</option>
                @endif
            @endforeach
        </select>
    </div>
    <div class="button_wrapper clearfix">
        <div class="button_wrapper_content">
            <input class="button" type="submit" value="create user">
        </div>
    </div>
</form>
@stop