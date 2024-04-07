# Laravel with docker (SellerLogic Test Task)

### Locally Installation

#### Option 1
- `cp .env.example .env`
- `docker-compose up -d`
- `docker-compose exec app bash`
- `composer install`
- `php artisan key:generate`
- `php artisan migrate:fresh`
- `php artisan ide-helper:model -M`
- `composer install --working-dir=tools/php-cs-fixer`
- `composer install --working-dir=tools/phpstan`
- `composer install --working-dir=tools/psalm`

#### Option 2 with make
- `make up`
- `make init`

---

### Check code (psalm, phpstan, php-cs-fixer)
- `docker-compose exec app bash`
- `composer run code_check`

### Fix code style
- `docker-compose exec app bash`
- `composer run fix_style`