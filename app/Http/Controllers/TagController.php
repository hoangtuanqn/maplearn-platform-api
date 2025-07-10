<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\QueryBuilder\QueryBuilder;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tags = QueryBuilder::for(Tag::class)
            ->allowedFilters(['name'])
            ->allowedSorts(['created_at'])->get();

        return response()->json($tags, Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Tag $tag)
    {
        return response()->json($tag, Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Tag $tag)
    {
        Gate::authorize('create', $tag);
        $tag = Tag::create($request->validate([
            'name' => 'required|string|max:255',
        ]));
        return response()->json($tag, Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('update', $tag);
        $tag->update($request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]));

        return response()->json($tag, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        Gate::authorize('delete', $tag);
        $tag->delete();
        return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
    }
}
