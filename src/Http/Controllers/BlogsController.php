<?php

namespace Bishopm\Blog\Http\Controllers;

use Bishopm\Blog\Repositories\BlogsRepository;
use Bishopm\Blog\Repositories\UsersRepository;
use Bishopm\Blog\Repositories\SettingsRepository;
use Bishopm\Blog\Models\Blog;
use Bishopm\Blog\Models\Setting;
use Bishopm\Blog\Models\User;
use App\Http\Controllers\Controller;
use Bishopm\Blog\Http\Requests\CreateBlogRequest;
use Bishopm\Blog\Http\Requests\UpdateBlogRequest;
use Bishopm\Blog\Notifications\NewBlogPost;
use Bishopm\Blog\Notifications\NewBlogComment;
use Carbon\Carbon;
use MediaUploader;
use Auth;
use App;
use Feed;
use Illuminate\Http\Request;

class BlogsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $blog;
    private $user;
    private $settings;

    public function __construct(BlogsRepository $blog, UsersRepository $user, SettingsRepository $settings)
    {
        $this->blog = $blog;
        $this->user = $user;
        $this->settings = $settings;
    }

    public function index($username)
    {
        $blogs = $this->blog->all();
        return view('blog::blogs.index', compact('blogs', 'username'));
    }

    public function edit($username, Blog $blog)
    {
        $tags=Blog::allTags()->get();
        $media=Blog::find($blog->id)->getMedia('image')->first();
        $btags=array();
        foreach ($blog->tags as $tag) {
            $btags[]=$tag->name;
        }
        return view('blog::blogs.edit', compact('blog', 'tags', 'btags', 'media', 'username'));
    }

    public function subject($username, $tag)
    {
        $userid = User::where('name', $username)->first()->id;
        $allblogs = Blog::wheretag($tag)->get();
        $blogs=array();
        foreach ($allblogs as $blog) {
            if ($blog->user_id==$userid) {
                $blogs[strtotime($blog->created_at)]=$blog;
            }
        }
        krsort($blogs);
        return view('blog::blogs.subject', compact('username', 'blogs', 'tag', 'userid'));
    }

    public function search($username, Request $request)
    {
        $search = $request->search;
        $userid = User::where('name', $username)->first()->id;
        $title=ucfirst($this->settings->get("blog_title",$userid)) . " - " . $this->settings->get("blog_subtitle",$userid) . ": Search results";
        $blogs = $this->blog->search($userid, $request->search);
        return view('blog::blogs.search', compact('username', 'blogs', 'userid', 'search', 'title'));
    }

    public function create($username)
    {
        $tags=Blog::allTags()->get();
        return view('blog::blogs.create', compact('tags', 'username'));
    }

    public function show($username, $year, $month, $slug)
    {
        $testdate=$year . '-' . $month . '-%';
        $blog = Blog::where('slug', $slug)->where('created_at', 'like', $testdate)->first();
        $userid=$blog->user_id;
        $blogtitle=ucfirst($this->settings->get("blog_title",$userid));
        return view('blog::blogs.show', compact('blog', 'userid', 'username' , 'blogtitle'));
    }

    public function display($username)
    {
        $user = User::where('name', $username)->first();
        if ($user) {
            $title=ucfirst($this->settings->get("blog_title",$user->id)) . " - " . $this->settings->get("blog_subtitle",$user->id) . ": " . ucfirst($user->name) . "'s blog";
            $links=array();/*
            if ($this->settings->get('other_blogs', $user->id)) {
                $links = json_decode(stripslashes($this->settings->get('other_blogs', $user->id)));
            }*/
            $userid = $user->id;
            $blogs = $this->blog->allForBlogger($userid, 14);
            $tags=$this->blog->getTags($userid);
            return view('blog::blogs.display', compact('blogs', 'username', 'userid', 'tags', 'links', 'title'));
        } else {
            $data['message'] = "Blog author does not exist";
            return view('blog::templates.message', $data); 
        }
    }

    public function store($username, CreateBlogRequest $request)
    {
        $user = User::where('name', $username)->first();
        $request->request->add(['created_at' => $request->input('created_at') . ":00"]);
        $blog=$this->blog->create($request->except('tags', 'image'));
        $blog->tag($request->tags);
        if ($request->file('image')) {
            $fname=strval(time());
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('blogs')->useFilename($fname)->upload();
            $blog->attachMedia($media, 'image');
        }
        return redirect()->route('blogs.index', $username)
            ->withSuccess('New blog post added');
    }
    
    public function update($username, Blog $blog, UpdateBlogRequest $request)
    {
        $user = User::where('name', $username)->first();
        $request->request->add(['created_at' => $request->input('created_at') . ":00"]);
        $this->blog->update($blog, $request->except('tags', 'image'));
        $blog->tag($request->tags);
        if ($request->file('image')) {
            $fname=strval(time());
            $media = MediaUploader::fromSource($request->file('image'))
            ->toDirectory('blogs')->useFilename($fname)->upload();
            $blog->attachMedia($media, 'image');
        }
        return redirect()->route('blogs.index', $username)->withSuccess('Blog has been updated');
    }

    public function destroy($username, Blog $blog)
    {
        $blog->delete();
        return redirect()->route('blogs.index', $username)->withSuccess('Blog post has been deleted');
    }

    public function addtag($username, $blog, $tag)
    {
        $bb=Blog::find($blog);
        $bb->tag($tag);
    }

    public function removetag($username, $blog, $tag)
    {
        $bb=Blog::find($blog);
        $bb->untag($tag);
    }

    public function removemedia($username, $id)
    {
        $blog = Blog::find($id);
        $media = $blog->getMedia('image');
        $blog->detachMedia($media);
    }

    public function addcomment(Blog $blog, CreateCommentRequest $request)
    {
        $user=$this->user->find($request->user);
        $author=$blog->individual->user;
        $user->comment($blog, $request->newcomment);
        $message=$user->individual->firstname . " " . $user->individual->surname . " has posted a comment on your blog post: '" . $blog->title . "'";
        $author->notify(new NewBlogComment($message));
    }

    public function feed($username, $service="default")
    {
        $scope = User::where('name', $username)->first()->id;
        $this->settings->get('blog_title', $scope);
        $feed = App::make("feed");
        // cache the feed for 60 minutes (second parameter is optional)
        $feed->setCache(0, ucfirst($username) . '\'s Blog Feed');
        // check if there is cached feed and build new only if is not
        if (!$feed->isCached()) {
            // creating rss feed with our most recent 20 posts
            $blogs = Blog::where('status', 'Published')->where('created_at', '>', '2016-02-13')->orderBy('created_at', 'desc')->take(20)->get();
            // set your feed's title, description, link, pubdate and language
            $feed->title = ucfirst($this->settings->get('blog_title', $scope));
            $feed->description = ucfirst($this->settings->get('blog_subtitle', $scope));
            $feed->logo = $this->settings->get('avatar_link', $scope);
            $feed->link = url('feed');
            $feed->setDateFormat('datetime'); // 'datetime', 'timestamp' or 'carbon'
            $feed->pubdate = date('d-m-Y');
            $feed->lang = 'en';
            $feed->setShortening(true); // true or false
            $feed->setTextLimit(120); // maximum length of description text
            $feeddata=array();
            foreach ($blogs as $blog) {
                // set item's title, author, url, pubdate, description and content
                if ($blog->image) {
                    $imgurl=$blog->image;
                } else {
                    $imgurl=$feed->logo;
                }
                $dum['title']=$blog->title;
                $dum['author']=ucfirst($blog->user->name);
                $dum['link']=url('/' . date("Y", strtotime($blog->created_at)) . '/' . date("m", strtotime($blog->created_at)) . '/' . $blog->slug);
                $dum['pubdate']=$blog->created_at;
                $dum['summary']="New blog post: " . $blog->title;
                if ($service=="default") {
                    $dum['content']="<h2><a href=\"" . $dum['link'] . "\">" . $blog->title . "</a></h2><img src=\"" . $imgurl . "\">" . $blog->body;
                } else {
                    $dum['content']="New blog post: " . $blog->title . " " . $dum['link'];
                }
                $feeddata[]=$dum;
            }
            usort($feeddata, function ($a, $b) {
                return strcmp($b["pubdate"], $a["pubdate"]);
            });
        }
        foreach ($feeddata as $fd) {
            $feed->add($fd['title'], $fd['author'], $fd['link'], $fd['pubdate'], $fd['summary'], $fd['content']);
        }
        return $feed->render('atom');
    }

    public function apiaddcomment($blog, Request $request)
    {
        $blog=$this->blog->find($blog);
        $user=$this->user->find($request->user_id);
        $user->comment($blog, $request->comment);
    }

    public function apiblog($id)
    {
        if ($id=="current") {
            $blog=Blog::with('individual')->where('status', 'published')->orderBy('created_at', 'DESC')->first();
        } else {
            $blog=Blog::with('individual')->where('id', $id)->first();
        }
        $data=array();
        foreach ($blog->comments as $comment) {
            $author=$this->user->find($comment->commented_id);
            $comment->author = $author->individual->firstname . " " . $author->individual->surname;
            $comment->image = "http://umc.org.za/public/storage/individuals/" . $author->individual_id . "/" . $author->individual->image;
            $comment->ago = Carbon::parse($comment->created_at)->diffForHumans();
        }
        $data['user']='';
        if ($blog->individual->user) {
            $data['user']=$blog->individual->user->id;
        }
        $data['comments']=$blog->comments;
        $data['title']=$blog->title;
        $data['body']=$blog->body;
        $data['author']=$blog->individual->firstname . " " . $blog->individual->surname;
        $data['pubDate']=date("j F Y", strtotime($blog->created_at));
        $data['tags']=$blog->tags;
        $data['id']=$blog->id;
        return $data;
    }

    public function apiblogs()
    {
        $blogs=array();
        $dum=array();
        $allblogs=Blog::with('individual')->where('status', 'published')->orderBy('created_at', 'DESC')->get();
        foreach ($allblogs as $blog) {
            $dum['title']=$blog->title;
            $dum['author']=$blog->individual->firstname . " " . $blog->individual->surname;
            $dum['pubDate']=date("d M Y", strtotime($blog->created_at));
            $dum['id']=$blog->id;
            $dum['tags']=$blog->tags;
            $blogs[]=$dum;
        }
        return $blogs;
    }
}
