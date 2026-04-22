#!/usr/bin/env bash
set -e

# Run database migrations on container startup if DB is configured.
# This is safer than running migrations at image build time, which may hide failures.
if [ -n "${DB_HOST:-}" ]; then
    echo "Running migrations..."
    tries=0
    until php artisan migrate --force; do
        tries=$((tries + 1))
        if [ "$tries" -ge 5 ]; then
            echo "Migration failed after $tries attempts. Continuing startup." >&2
            break
        fi
        echo "Waiting for database connection..."
        sleep 3
    done
fi

exec apache2-foreground
