<?php

namespace App\Http\Controllers;

use App\Events\PostCreated;
use App\Http\Requests\StorePostRequest;
use App\Jobs\ChangePost;
use App\Mail\PostCreatedMail;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $posts = Post::paginate(6);

        return view('posts.index')->with('posts', $posts);
    }

    public function store(StorePostRequest $request)
    {
        if ($request->hasFile('photo')) {
            $name = $request->file('photo')->getClientOriginalName();
            $paht = $request->file('photo')->storeAs('post-photos', $name);
        }

        $post = Post::create([
            'user_id' => auth()->user()->id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $paht ?? null,
        ]);

        if (isset($request->tags)) {
            foreach ($request->tags as $tag) {
                $post->tags()->attach($tag);
            }
        }

        PostCreated::dispatch($post);

        ChangePost::dispatch($post);

        Mail::to($request->user())->later(now()->addMinute(1), (new PostCreatedMail($post))->onQueue('mails'));

        return redirect()->route('posts.index');
    }

    public function create()
    {
        return view('posts.create')->with([
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function show(Post $post)
    {
        return view('posts.show')->with([
            'post' => $post,
            'recent_posts' => Post::latest()
                ->get()
                ->except($post->id)
                ->take(5),
            'categories' => Category::all(),
            'tags' => Tag::all(),
        ]);
    }

    public function edit(Post $post)
    {
        Gate::authorize('update', $post);

        return view('posts.edit')->with(['post' => $post]);
    }

    public function update(StorePostRequest $request, Post $post)
    {
        if ($request->hasFile('photo')) {
            if (isset($post->photo)) {
                Storage::delete($post->photo);
            }

            $name = $request->file('photo')->getClientOriginalName();
            $name = $request->file('photo')->getClientOriginalName();
            $paht = $request->file('photo')->storeAs('post-photos', $name);
        }

        $post->update([
            'title' => $request->title,
            'short_content' => $request->short_content,
            'content' => $request->content,
            'photo' => $paht ?? $post->photo,
        ]);

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    public function destroy(Post $post)
    {
        Gate::authorize('update', $post);

        if (isset($post->photo)) {
            Storage::delete($post->photo);
        }

        $post->delete();

        return redirect()->route('posts.index');
    }
}
