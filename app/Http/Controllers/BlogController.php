<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Liste des articles, avec filtre optionnel par catégorie (?category=).
     */
    public function index(Request $request): View
    {
        $categories = Post::published()->distinct()->orderBy('category')->pluck('category');
        $active = $request->query('category');

        $query = Post::published()->latest('published_at');

        if ($active && $categories->contains($active)) {
            // Vue filtrée : pas d'article « à la une », toute la grille correspond au filtre.
            $featured = null;
            $posts = (clone $query)->where('category', $active)->get();
        } else {
            $active = null;
            $featured = Post::published()->where('is_featured', true)->latest('published_at')->first();
            $posts = $query->when($featured, fn ($q) => $q->whereKeyNot($featured->id))->get();
        }

        return view('blog.index', compact('categories', 'active', 'featured', 'posts'));
    }

    /**
     * Affichage d'un article + suggestions « à lire ensuite ».
     */
    public function show(Post $post): View
    {
        abort_if($post->published_at === null || $post->published_at->isFuture(), 404);

        // 3 articles liés : même catégorie en priorité, complétés par les plus récents.
        $related = Post::published()
            ->whereKeyNot($post->id)
            ->where('category', $post->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $related = $related->merge(
                Post::published()
                    ->whereKeyNot($post->id)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->latest('published_at')
                    ->take(3 - $related->count())
                    ->get()
            );
        }

        return view('blog.show', compact('post', 'related'));
    }
}
