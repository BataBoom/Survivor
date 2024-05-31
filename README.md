NFL Survivor + Pickem

```
git clone git@github.com:BataBoom/Survivor.git
cd Survivor
composer install
npm install
npm run build
mv .env.example .env
define .env
php artisan config:clear
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Login: admin@github.com
Password: YourAdminPassword (or as defined in .env)

Admin panel included on /admin though working out some kinks still



![](https://i.imgur.com/MiHsVs0.png)
![](https://i.imgur.com/njHpkJD.png)
