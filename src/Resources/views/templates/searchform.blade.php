<form method="POST" action="{{route('blogs.search',$username)}}">
    {{ csrf_field() }}
    <div class="input-group">
        <input class="form-control" name="search" type="text" placeholder="Search">
        <span class="input-group-append">
            <button class="btn btn-dark" type="submit">
            <i class="fa fa-search"></i>
            </button>
        </span>
        @auth
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-transparent dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="sr-only">Toggle Dropdown</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="btn btn-sm" href="{{route('blogs.index',$username)}}"><i class="fa fa-fw fa-list"></i> View all posts</a>
                    <a class="btn btn-sm" href="{{route('blogs.create',$username)}}"><i class="fa fa-lg fa-plus"></i> Add a new post</a>
                    <a class="btn btn-sm" href="{{route('settings.index',$username)}}"><i class="fa fa-lg fa-cog"></i> Settings</a>
                    <a class="btn btn-sm" href="{{route('logout')}}"><i class="fa fa-lg fa-sign-out-alt"></i> Log out</a>
                </div>
            </div>
        @else
            <a title="Login" class="btn btn-light" href="{{route('login')}}"><i class="fa fa-lg fa-sign-in-alt"></i></a>
        @endauth
    </div>
</form>