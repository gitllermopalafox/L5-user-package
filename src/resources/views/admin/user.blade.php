@extends("user::masters.admin")

@section("content")

<h2>User</h2>

<!-- Messages. -->
@if($errors)
    <ul class="message message-error">
    @foreach ($errors as $error)
        <li>{{ $error }}</li>
    @endforeach
    </ul>
@endif

<!-- Form. -->
<form method="post">
    {!! csrf_field() !!}
    <div class="form_item">
        <label class="label" for="username">Username <span>(Can not be changed)</span></label>
        <input class="input-text" type="text" value="{{ $user->username }}" readonly="readonly" disabled="disabled">
    </div>
    <div class="form_item">
        <label class="label" for="email">Email</label>
        <input class="input-text" name="email" type="text" value="{{ $user->email }}">
    </div>
    @if(SidneyDobber\User\AEUser::authorize('user'))
        <div class="form_item">
            <label class="label" for="userrole">Userrole</label>
            <select name="userrole" id="userrole">
                @foreach($userroles as $key => $value)
                    @if($key == $userrole_value)
                        <option {{ 'selected' }}>{{ $key }}</option>
                    @else
                        <option>{{ $key }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    @endif 
    <div class="button_wrapper clearfix">
        <div class="button_wrapper_content">
            <input class="button" type="submit" value="Update">
        </div>
    </div>
</form>

@stop