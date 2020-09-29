# Telegram polls without group

little help to send different types of polls to my telegram clients.

## Installation

Use composer to install telegram-polls-without-groups.

```bash
composer require sergiobogatsky/telegram-polls-without-group
```

Do the migration:
```bash
php artisan migrate
```

Publish provider and select it inside of the list:
```bash
php artisan vendor:publish --force
```

Put the code before on first position of webhook controller of telegram:
```bash
//polls added from SergioBogatsky\TelegramPollsWithoutGroup
        if (Poll::checkAndSavePollAnswer($request)) {
            return;
        }
```

## License
[MIT](https://choosealicense.com/licenses/mit/)
