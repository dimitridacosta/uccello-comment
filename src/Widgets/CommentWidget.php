<?php

namespace Uccello\Comment\Widgets;

use Arrilot\Widgets\AbstractWidget;

class CommentWidget extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        // $domain = $this->config['domain'];

        return view('comment::widgets.comment_widget', [
            'config' => $this->config,
            // 'chart' => $chart,
        ]);
    }
}
