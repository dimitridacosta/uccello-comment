Document Designer is a [Laravel/Ucello](https://github.com/uccellolabs/uccello) Package allowing to add a comment widget linked to any Uccello entity.

## Features

- Comments linked to any Uccello entity
- Create / Edit / Delete comments by users
- Reply to any first level comments


## Installation

#### Package
```bash
composer require uccello/comment
```

#### Use

To add a comment widget, add the flowing line in any blade view of your Uccello project:
```blade
@widget('Uccello\Comment\Widgets\CommentWidget', 
        ['title' => 'Comments', 'entity' => $record])
```

The parameters are:
- `title`: Title of the comment card
- `entity`: Uccello entity to comment on
