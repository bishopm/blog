<?php

namespace Bishopm\Blog\Http\Controllers;

use Auth;
use Bishopm\Blog\Models\User;
use Bishopm\Blog\Models\Book;
use Bishopm\Blog\Models\LinkedSocialAccount;
use Bishopm\Blog\Repositories\UsersRepository;
use Actuallymab\LaravelComment\Models\Comment;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * @var UserRepository
     */
    private $user;

    public function __construct(UsersRepository $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->user->all();
    }

    /**
     * Login or create user
     *
     * @return Response
     */
    public function register(Request $request)
    {
        $user = User::create(['email' => $request->email, 'name' => $request->name, 'password' => bcrypt($request->password), 'authorised'=>0]);
        if ($user->id==1) {
            $user->authorised=1;
        }
        $user->save();
        return $user;
    }

    /**
     * Display an individual resource.
     *
     * @return Response
     */
    public function show($id)
    {
        return $this->user->find($id);
    }

    public function home($id)
    {
        $data['books'] = Book::where('owned', 1)->count();
        $data['toprated'] = $this->book->toprated();
        $data['users'] = User::all()->count();
        $data['comments'] = Comment::all()->count();
        $data['user'] = $this->user->find($id);
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */

    public function store(Request $request)
    {
        return $this->user->create($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  User $user
     * @param  Request $request
     * @return Response
     */
    public function update(User $user, Request $request)
    {
        $user = $this->user->update($user, $request->all());
        return $user;
    }

    public function authorise($id, Request $request)
    {
        $user = User::find($id);
        if ($request->action == "authorise") {
            return $this->user->update($user, ['authorised'=>1]);
        } elseif ($request->action == "delete") {
            $user->delete();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $this->user->destroy($user);
        return "deleted!";
    }
}
