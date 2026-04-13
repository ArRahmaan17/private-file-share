#!/bin/sh
set -e

cd /var/www/html

# The compose bind mount can reintroduce stale local cache manifests that reference
# dev-only providers such as Laravel Pail. Rebuild them against the installed vendor set.
rm -f bootstrap/cache/*.php
php artisan schedule:work --no-interaction --verbose &

exec "$@"
