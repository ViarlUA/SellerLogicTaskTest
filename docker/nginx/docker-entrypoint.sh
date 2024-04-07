#!/bin/sh

log_file="/var/log/nginx/access.log"

# Проверяем существует ли файл и является ли он символической ссылкой
if [ -e "$log_file" ] && [ -L "$log_file" ]; then
    unlink "$log_file"  # Отвязываем символическую ссылку
fi

exec "$@"