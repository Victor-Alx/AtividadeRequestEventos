```sh
git clone https://github.com/nato-re/falaq-base.git
cd falaq-base
composer install
npm install
npm run build
cp .env.example .env
php artisan key:generate
php artisan migrate

```