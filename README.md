# Laravel with docker (SellerLogic Test Task)

### Locally Installation
- `cp .env.example .env`

#### Option 1
- `docker-compose up -d`
- `docker-compose exec app bash`
- `composer install`
- `php artisan key:generate`
- `php artisan migrate:fresh`
- `php artisan ide-helper:model -M`
- `composer install --working-dir=tools/php-cs-fixer`
- `composer install --working-dir=tools/psalm`

#### Option 2 with make
- `make up`
- `make init`

---

### Check code (psalm, php-cs-fixer)
- `docker-compose exec app bash`
- `composer run code_check`

### Fix code style
- `docker-compose exec app bash`
- `composer run fix_style`


---
### Commands

#### display-log
- `php artisan display-log:count <startDate> <finishDate>` Display the count of records from the database within a specified time range using Log
- `php artisan display-log:records <startDate> <finishDate> [--chunk=1000] [--vertical]` Display records from the database within a specified time range using Log


#### monitor-log
- `php artisan monitor-log:monitor-log-nginx <path>` Monitor Nginx access log and save new data to ClickHouse
- `php artisan monitor-log:read-log-nginx <path> <chunk=10000>` Reading Nginx logs and save new data to ClickHouse
