all:
	echo idle

reset:
	composer.phar dumpautoload
	./artisan migrate:reset
	./artisan migrate
	./artisan db:seed
	./artisan ratings:sync
