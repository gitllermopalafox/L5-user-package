@section("header")
    <div id="header">
        <div id="header_content" class="clearfix">
            <div id="authorization">
                @if (Auth::check())
                    <a href="/logout">logout</a> |
                    <a href="/admin/users/{{ Auth::user()->id }}">{{ Auth::user()->username }}</a>
                @endif
            </div>
        </div>
    </div>
@show