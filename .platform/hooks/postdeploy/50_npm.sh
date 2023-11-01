#!/usr/bin/env bash
cd /var/app/current/
#npm install && node --max-old-space-size=1536 `which npm` run dev
sudo -u webapp php artisan storage:link
sudo -u webapp php artisan cache:clear
sudo -u webapp /usr/bin/composer.phar dump-autoload
sudo -u webapp php artisan config:cache
# sudo -u webapp chown $USER:webapp ./storage -R
# sudo -u webapp find ./storage -type d -exec chmod 775 {} \;
# sudo -u webapp find ./storage -type f -exec chmod 664 {} \;
sudo -u webapp chmod -R 777 storage
