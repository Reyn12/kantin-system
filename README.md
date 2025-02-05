# Kantin System

Sistem manajemen kantin dengan fitur pemesanan, kasir, dan admin panel.

## Fitur

- 🛒 Pemesanan makanan/minuman
- 💳 Dashboard Kasir
- 📊 Admin Panel
- 🧾 Cetak Invoice
- 📱 Responsive Design

## Requirement

- PHP >= 8.0
- Composer
- MySQL/MariaDB
- Node.js & NPM

## Cara Install

1. Clone repository ini
```bash
git clone https://github.com/Reyn12/kantin-system.git
cd kantin-system
```

2. Install dependencies PHP
```bash
composer install
```

3. Install dependencies JavaScript
```bash
npm install
```

4. Rename file .env.example jadi .env
```bash
cp .env.example .env
```

5. Setting database di file .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kantin_system
DB_USERNAME=root
DB_PASSWORD=
```

6. Jalankan migration dan seeder
```bash
php artisan migrate --seed
```

7. Jalankan server
```bash
php artisan serve
```

8. Jalankan npm
```bash
npm run dev
```

Struktur Folder
kantin-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── CategoryController.php
│   │   │   │   └── ProductController.php
│   │   │   ├── Kasir/
│   │   │   │   └── OrderController.php
│   │   │   └── Customer/
│   │   │       └── OrderController.php
│   │   └── Middleware/
│   │       └── CheckRole.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Order.php
│       └── OrderItem.php
├── database/
│   └── migrations/
│       ├── create_users_table.php
│       ├── create_categories_table.php
│       ├── create_products_table.php
│       ├── create_orders_table.php
│       └── create_order_items_table.php
├── resources/
│   ├── css/
│   │   └── app.css
│   ├── js/
│   │   └── app.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── categories/
│       │   │   ├── index.blade.php
│       │   │   └── form.blade.php
│       │   └── products/
│       │       ├── index.blade.php
│       │       └── form.blade.php
│       ├── kasir/
│       │   ├── dashboard.blade.php
│       │   └── orders/
│       │       ├── index.blade.php
│       │       └── detail.blade.php
│       ├── customer/
│       │   ├── menu.blade.php
│       │   └── orders/
│       │       ├── cart.blade.php
│       │       └── history.blade.php
│       ├── components/
│       │   ├── navbar.blade.php
│       │   └── sidebar.blade.php
│       ├── layouts/
│       │   └── master.blade.php (yang tadi kita buat)
│       └── landing.blade.php
├── routes/
│   └── web.php
└── public/
    ├── images/
    │   └── products/
    └── build/ (hasil compile vite)