1. Povući projekat sa github-a
2. U terminalu pokrenuti komandu npm install
3. U terminalu pokrenuti komandu composer install
4. U mysql, phpMyAdmin kreirati bazu pod imenom blog2 (ili bilo kojim drugim imenom ali je tada potrebno promijeniti .env konfiguraciju)
5. Zatim u terminalu pokrenuti php artisan migrate
6. Zatim redom pokrenuti seedere php artisan db:seed --class=UsersTableSeeder, php artisan db:seed --class=PostsTableSeeder, php artisan db:seed --class=CommentSeeder
7. Koristiti dva terminala, u jednom pokrenuti npm run dev (za vue frontend), a u drugom php artisan serve
8. Aplikaciji pristupiti preko localhost:8000, u bazi vidjeti email za logovanje (postoje admin i obicni user profili), sifra svakog profila je 12345678
