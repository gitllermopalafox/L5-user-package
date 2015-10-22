@section("header")

    <div class="header">
        <div class="header_content">
            <div class="authorization">
                @if (Auth::check())
                    <a class="link--text" href="/logout">logout</a> |
                    <a class="link--text" href="/admin/users/{{ Auth::user()->id }}">{{ Auth::user()->username }}</a>
                @endif
            </div>
        </div>
    </div>

@show