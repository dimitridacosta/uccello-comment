<?php

namespace Uccello\Comment\Http\Controllers;

use Illuminate\Http\Request;
use Uccello\Core\Http\Controllers\Core\Controller;
use Uccello\Core\Models\Domain;
use Uccello\Comment\Models\Comment;

class CommentController extends Controller
{
    public function save(?Domain $domain, Request $request)
    {
        if ($request->id) // Edit
        {
            $comment = Comment::find($request->id);

            // Check user uwnership: if not the owner then create a new comment
            if ($comment->user_id != auth()->user()->id)
            {
                $comment = new Comment();
            }
        }
        else    // Create
        {
            $comment = new Comment();
        }

        if($request->parent)
        {
            if(Comment::find($request->parent))
            {
                $comment->parent_id = $request->parent;
            }
        }
        
        $comment->user_id   = auth()->user()->id;
        $comment->entity_id = $request->entity;
        $comment->content   = $request->content;
        // $comment->domain    = $domain;           // TODO: Domain ??

        $comment->save();

        return 'success';
    }
}
