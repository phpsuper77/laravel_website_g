@servers(['staging' => 'root@zhiyan.de', 'production' => '95.85.34.194'])

@task('stage', ['on' => 'staging'])
    cd /var/www/cyberystudio/sites/gooeypress
    git pull origin master

    cd ./back/
    /usr/local/bin/composer.phar self-update
    /usr/local/bin/composer.phar update
    /usr/local/bin/composer.phar dumpautoload

    ./artisan key:generate
    ./artisan migrate:reset
    ./artisan migrate
    ./artisan db:seed

    cd ../front/
    grunt deploy

    cd ../phantomjs/
    killall php
    nohup php screenshot.php &
    nohup php yslow.php &
@endtask

@after
    @slack('zhiyan', 'FiMBG5xEIROb5aLBhDmnKkO', '#gooeypress-staging')
@endafter
