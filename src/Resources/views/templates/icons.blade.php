<div class="btn-group float-right">
    <button class="btn btn-transparent btn-sm" type="button">
        <a href="{{route('blogs.display',$username)}}"><i class="fa fa-home"></i></a>
    </button>
    @auth
        <button type="button" class="btn btn-sm btn-transparent dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span class="sr-only">Toggle Dropdown</span>
        </button>
        <div class="dropdown-menu dropdown-menu-right">
            <a class="btn btn-sm" href="{{route('blogs.index',$username)}}"><i class="fa fa-fw fa-list"></i> View all posts</a>
            <a class="btn btn-sm" href="{{route('blogs.create',$username)}}"><i class="fa fa-lg fa-plus"></i> Add a new post</a>
            @if (isset($blog))
                <a class="btn btn-sm" href="{{route('blogs.edit',array($username,$blog->id))}}"><i class="fa fa-lg fa-edit"></i> Edit this post</a>
            @endif
            <a class="btn btn-sm" href="{{route('settings.index',$username)}}"><i class="fa fa-lg fa-cog"></i> Settings</a>
            <a class="btn btn-sm" href="{{route('logout')}}"><i class="fa fa-lg fa-sign-out-alt"></i> Log out</a>
        </div>
    @else 
        <a title="Login" class="btn btn-sm btn-light" href="{{route('login')}}"><i class="fa fa-lg fa-sign-in-alt"></i></a>
    @endauth
</div>