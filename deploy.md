## Initialize folder structure
1. Create releases & shared folders under project root
   ```sh
   cd /data/quizfunz/nse2/sedondary
   mkdir releases shared
   ```

## How to deploy

1. cd to releases path
   ```sh
   cd {path, e.g. /data/quizfunz/nse2/secondary/releases }
   ```
2. Clone git repository
   ``` sh
   git clone -b dev --depth=1 git@gitlab.com:btguys/csd_quizfunz.git {timestamp, e.g. 20211007_183700}
   ```
3. Create symlink of .env & storage
   ```sh
   # if it is the first time deploy
   chmod -R 777 storage
   mv storage ../../shared/storage

   # otherwise
   rm -rf storage

   # Create symlink
   ln -s ../../shared/.env .env
   ln -s ../../shared/storage storage
   ```
4. Update .env config (if any)
5. Install composer dependencies
   ```sh
   composer install --optimize-autoloader --no-dev
   ```
6. Install bower dependencies
   ```sh
   bower install
   ```
7. Change permission of folders
   ```sh
   chmod -R 777 boostrap/cache
   ```
8. Generate config, route cache
   ```sh
   php artisan config:cache
   php artisan route:cache
   ```
9. Create current symlink to latest release folder
   ```sh
   cd /data/quizfunz/nse2/secondary/
   ln -sfn releases/20211007_183700 current
   ```

    