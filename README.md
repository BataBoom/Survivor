```
git clone git@github.com:BataBoom/Survivor.git
cd Survivor
composer install
npm install
npm run build
mv .env.example .env
define .env
php artisan migrate
php artisan db:seed
```

Still in development, Refactoring last years version.
