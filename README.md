# Checkers

This repository contains an checkers game that can be played via the CLI. The user can make a move by giving the position of the stone the user like to move and the position the user to where the user want to move the stone.

## Functionalities
- Moving the stones based on the given positions.
- Capture stones of his opponent if that is possible. 
- Once an user is able to capture a stone of his opponent, it MUST be captured.
- Once a stone has made it all the way across the board, it turns into a king.
- A king is able to move forward but also backwards. 
- A king is able to capture backwards.

## How to play

To play this game you need to clone this repository:

```php
git clone 
```

Once it is cloned move to the directory and run composer:

```php
composer install
composer dump-autoload
```

Now you're all set. Now to start the game run:

```php
php checkers.php
```

The stones at from Y-9 till Y-6 are white and the other stones are black.
