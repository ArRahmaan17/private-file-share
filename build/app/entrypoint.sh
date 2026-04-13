#!/bin/sh
set -e

cd /var/www/html

# The compose bind mount can reintroduce stale local cache manifests that reference
# dev-only providers such as Laravel Pail. Rebuild them against the installed vendor set.
chown -R www-data:www-data bootstrap/cache/*.php storage/logs/*.log
rm -f bootstrap/cache/*.php
php artisan package:discover --ansi
php artisan schedule:work --no-interaction --verbose &

exec "$@"
