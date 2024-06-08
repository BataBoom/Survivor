NFL Survivor + Pickem

```
git clone git@github.com:BataBoom/Survivor.git
cd Survivor
composer install
npm install
npm run build
cp .env.example .env
define .env
php artisan config:clear
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Login: admin@github.com
Password: YourAdminPassword (or as defined in .env)

Admin panel included on /admin, publish the assets using:
```
php artisan filament:assets
```


![](https://i.imgur.com/if0T9Jw.png)
![](https://i.imgur.com/njHpkJD.png)
