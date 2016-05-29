#!/bin/bash

set -x

env >> /etc/default/locale
/etc/init.d/cron start

apache2-foreground

exec "$@"
