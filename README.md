### Route Cache Clear
```bash
php artisan route:clear
```
### Özel alanları migrate yapma sildikten sonra
```bash
php artisan migrate:refresh --path=/database/migrations/2022_03_11_132132_create_customer_drivers_table.php
```
