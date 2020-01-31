<div class="card">
    <div class="card-content">
        <span class="card-title">{!! $config['title'] !!}</span>

        <div class="uc-comments">
            <div class="uc-header row">
                <div class="user-image col">
                    @if (in_array(auth()->user()->avatarType, [ 'image', 'gravatar' ]))
                        <img src="{{ auth()->user()->image }}" alt="" class="circle responsive-img">
                    @else
                        <div class="circle user-initials grey lighten-2">{{ auth()->user()->initials }}</div>
                    @endif
                </div>
                <div class="input-field col">
                    <textarea id="uc-content" class="materialize-textarea"></textarea>
                    <label id="uc-cont-lbl" for="uc-content">Your new comment</label>
                </div>
                <button class="btn-floating waves-effect waves-light" id="uc-save">
                    <i class="material-icons right">send</i>
                </button>
            </div>
            <div class="uc-content">
                @foreach(Uccello\Comment\Models\Comment::where('entity_id', $config['entity']->uuid)
                                                        ->whereNull('parent_id')
                                                        ->orderby('created_at', 'desc')
                                                        ->get() as $comment)
                <div class="uc-comment row" id="uc-comment-{{ $comment->id }}" style="margin-bottom: 20px">
                    <div class="user-image col">
                        @if (in_array($comment->user->avatarType, [ 'image', 'gravatar' ]))
                            <img src="{{ $comment->user->image }}" alt="" class="circle responsive-img">
                        @else
                            <div class="circle user-initials grey lighten-2">{{ $comment->user->initials }}</div>
                        @endif
                    </div>
                    <div class="uc-main col">
                        <div class="uc-comment-header row">
                            <div class="col uc-user">
                                {{ $comment->user->recordLabel }}
                            </div>
                            <div class="col">
                                {{ (new \Carbon\Carbon($comment->updated_at))->format(config('uccello.format.php.datetime')) }} 
                            </div>
                            @if ($comment->updated_at != $comment->created_at)
                            <div class="col">
                                (Modifié)
                                {{-- TODO: Translation --}}
                            </div>
                            @endif
                            <div class="col">
                                <a href="javascript:void(0)"
                                data-tooltip="{{ uctrans('button.reply', $module) }}"
                                data-position="top"
                                data-comment-id={{ $comment->id }}
                                class="reply-btn primary-text">
                                <i class="material-icons">reply</i>
                                </a>
                                @if (auth()->user()->id == $comment->user->id)
                                <a href="javascript:void(0)"
                                    data-tooltip="{{ uctrans('button.edit', $module) }}"
                                    data-position="top"
                                    data-comment-id={{ $comment->id }}
                                    class="edit-btn primary-text">
                                    <i class="material-icons">edit</i>
                                </a>
                                <a href="javascript:void(0)"
                                    data-tooltip="{{ uctrans('button.delete', $module) }}" 
                                    data-position="top" 
                                    class="delete-btn primary-text" 
                                    data-config='{"actionType":"link","confirm":true,"dialog":{"title":"{{ uctrans('confirm.button.delete_record', $module) }}"}}'>
                                    <i class="material-icons">delete</i>
                                </a>
                                @endif
                            </div>
                        </div>
                        <div class="uc-comment-content">
                            {!! nl2br($comment->content) !!}
                        </div>
                        @if($replyCount = Uccello\Comment\Models\Comment::where('parent_id', $comment->id)->count())
                        <a class="uc-toggle-reply waves-effect btn-flat" data-comment-id={{ $comment->id }}>▴ HIDE {{$replyCount}} REPLIES</a>
                        <a class="uc-toggle-reply waves-effect btn-flat" data-comment-id={{ $comment->id }} style="display:none">▾ SHOW {{$replyCount}} REPLIES</a>
                        <div class="uc-reply uc-toggle-reply">
                            @foreach(Uccello\Comment\Models\Comment::where('parent_id', $comment->id)
                                                                    ->orderby('created_at', 'desc')
                                                                    ->get() as $reply)
                            <div class="uc-comment row" id="uc-comment-{{ $reply->id }}" style="margin-bottom: 20px">
                                <div class="user-image col">
                                    @if (in_array($reply->user->avatarType, [ 'image', 'gravatar' ]))
                                        <img src="{{ $reply->user->image }}" alt="" class="circle responsive-img">
                                    @else
                                        <div class="circle user-initials grey lighten-2">{{ $reply->user->initials }}</div>
                                    @endif
                                </div>
                                <div class="uc-main col">
                                    <div class="uc-comment-header row">
                                        <div class="col uc-user">
                                            {{ $reply->user->recordLabel }}
                                        </div>
                                        <div class="col">
                                            {{ (new \Carbon\Carbon($reply->updated_at))->format(config('uccello.format.php.datetime')) }} 
                                        </div>
                                        @if ($reply->updated_at != $reply->created_at)
                                        <div class="col">
                                            (Modifié)
                                            {{-- TODO: Translation --}}
                                        </div>
                                        @endif
                                        <div class="col">
                                            @if (auth()->user()->id == $reply->user->id)
                                            <a href="javascript:void(0)"
                                                data-tooltip="{{ uctrans('button.edit', $module) }}"
                                                data-position="top"
                                                data-comment-id={{ $reply->id }}
                                                class="edit-btn primary-text">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="javascript:void(0)"
                                                data-tooltip="{{ uctrans('button.delete', $module) }}" 
                                                data-position="top" 
                                                class="delete-btn primary-text" 
                                                data-config='{"actionType":"link","confirm":true,"dialog":{"title":"{{ uctrans('confirm.button.delete_record', $module) }}"}}'>
                                                <i class="material-icons">delete</i>
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="uc-comment-content">
                                        {!! nl2br($reply->content) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('extra-meta')
<meta name="save-url" content="{{ ucroute('uccello.comment.save', $domain) }}">
<meta name="entity-uuid" content="{{ $config['entity']->uuid }}">
<meta name="comment-id" content="">
<meta name="parent-id" content="">
@append

@section('extra-script')
{!! Html::script(mix('js/comment.js', 'vendor/uccello/comment')) !!}

<style>
.uc-comments .row {
    margin-bottom: 0;
}
.uc-comments .uc-user {
    font-weight: bold;
}
.uc-comments a i {
    font-size: 18px;
}
.uc-comments .uc-content {
    overflow-y: auto;
    max-height: 450px;
    padding-top: 20px;
}
.uc-comments .uc-main {
    max-width: calc(100% - 68px);
}
.uc-comments .uc-header .input-field {
    margin: 0px;
    width: calc(100% - 130px);
    max-width: 400px;
}
.uc-comments .uc-comment-header {
    width: max-content;
}
</style>

@append
