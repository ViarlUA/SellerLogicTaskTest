# Laravel with docker

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
- `composer install --working-dir=tools/rector`

#### Option 2 with make
- `make up`
- `make init`

---

### Demo Credentials

**User:** test@example.com  
**Password:** password1D

**User:** test2@example.com  
**Password:** password1D

---


### Check code (psalm, phpstan, php-cs-fixer)
- `docker-compose exec app bash`
- `composer run code_check`

### Fix code style
- `docker-compose exec app bash`
- `composer run fix_code`

### Check rector after update PHP or Laravel
- `docker-compose exec app bash`
- `composer run rector_check`
---

### Run test
- `docker-compose exec app bash`
- `php artisan test`

### Run generate api docs
-  `docker-compose exec app bash`
- `php artisan l5-swagger:generate`
- Link: `/api/documentation`