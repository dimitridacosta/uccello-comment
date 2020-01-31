export class Comment {
    constructor() {
        this.initListeners();
    }

    /**
     * Init event listeners
     */
    initListeners() {
        this.initSaveButtonListener();
        this.initClearButtonListener();
        this.initEditButtonsListener();
        this.initReplyButtonsListener();
        this.toggleReplyButtonsListener();
    }

    /**
     * Save current menu
     */
    save() {
        let url     = $("meta[name='save-url']").attr('content');
        let entity  = $("meta[name='entity-uuid']").attr('content');
        let parent   = $("meta[name='parent-id']").attr('content');
        let id      = $("meta[name='comment-id']").attr('content');
        let content = $(".uc-comments #uc-content").val();

        if (content != null && content != '') {
            $.ajax({
                url: url,
                method: "post",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    entity: entity,
                    parent: parent,
                    id: id,
                    content: content,
                }
            }).then((response) => {
                location.reload();
            }).fail((error) => {
                swal(uctrans.trans('uccello::default.dialog.error.title'), uctrans.trans('uccello::settings.menu_manager.error.save'), "error")
            })
        }
    }
    
        /**
         * Init save button listener
         */
        initSaveButtonListener() {
            $('.uc-comments .save-btn').on('click', (event) => {
                // Save comment
                this.save();
            })
        }

        /**
         * Init clear button listener
         */
        initClearButtonListener() {
            $('.uc-comments .clear-btn').on('click', (event) => {
                this.clear();

                $(".uc-comments #uc-content").trigger('autoresize'); // TODO: Not working =/
                $(".uc-comments #uc-content").focus();
            })
        }
    
        /**
         * Init edit buttons listener
         */
        initEditButtonsListener() {
            $('.uc-comments .edit-btn').on('click', (event) => {
                this.clear();
                
                var commentId = $(event.currentTarget).data('commentId');
                var content = $("#uc-comment-" + commentId + " .uc-comment-content").first().text().trim();

                console.log(content);
                
                $("meta[name='comment-id']").attr('content', commentId);
                $(".uc-comments #uc-content").val(content);
                $(".uc-comments #uc-content").trigger('autoresize'); // TODO: Not working =/
                $(".uc-comments #uc-content").focus();

                $(".uc-comments #uc-cont-lbl").text("Edit your comment");
            })
        }
        
        /**
         * Init reply buttons listener
         */
        initReplyButtonsListener() {
            $('.uc-comments .reply-btn').on('click', (event) => {
                this.clear();
                
                var replyId = $(event.currentTarget).data('commentId');
                var user = $("#uc-comment-" + replyId + " .uc-user").first().text().trim();
                
                $("meta[name='parent-id']").attr('content', replyId);
                $(".uc-comments #uc-content").focus();

                $(".uc-comments #uc-cont-lbl").text("Your reply to @" + user);
            })
        }
        
        /**
         * Toggle reply buttons listener
         */
        toggleReplyButtonsListener() {
            $('.uc-comments .uc-toggle-reply').on('click', (event) => {
                var replyId = $(event.currentTarget).data('commentId');

                $("#uc-comment-" + replyId + " .uc-toggle-reply").toggle();
            })
        }

        /**
         * Clear comment edit meta
         */
        clear()
        {               
            $("meta[name='comment-id']").attr('content', "");
            $("meta[name='parent-id']").attr('content', "");

            $(".uc-comments #uc-content").val("");
            $(".uc-comments #uc-content").trigger('autoresize'); // TODO: Not working =/
            
            $(".uc-comments #uc-cont-lbl").text("Your new comment");
        }
}

new Comment();
