# LaravelCataShop

> **Simple E-Commerce Solution** - Zero external dependencies, manual trust, maximum control.

[![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?logo=laravel)](https://laravel.com)
[![SQLite](https://img.shields.io/badge/SQLite-Database-003B57?logo=sqlite)](https://sqlite.org)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

A minimalist, production-ready e-commerce platform built with Laravel 11 that prioritizes simplicity, portability, and manual payment verification over complex integrations.

---

## 🎯 **Core Philosophy**

**"Digital Ledger, Manual Trust"**

- ✅ **Zero External Dependencies** - No payment gateways, no third-party services
- ✅ **Manual Trust** - Admin verifies all payments manually
- ✅ **SQLite Simplicity** - One file database, easy deployment
- ✅ **Dark Mode First** - Beautiful UI for both admin and customers

---

## ✨ **Features**

### **Admin Panel**
- 📊 Dashboard with real-time metrics
- 📂 Category & Product Management (multi-image upload)
- 📦 Order Processing & Status Updates
- ⭐ Review Moderation System
- 📈 Stock Control & Logging
- 🎨 Dark/Light Mode

### **Customer Features**
- 👤 Account Registration & Login
- 🏠 Multiple Address Management
- 📋 Order History Tracking
- ⭐ Product Reviews & Ratings
- 🛒 Shopping Cart
- 💳 Guest Checkout

### **Shopping Experience**
- 🏪 Product Catalog with Filters
- 🔍 Search Functionality
- 💰 Promotions & Discount System
- 🎫 Coupon Codes
- 📜 CMS (Blog, Pages, Banners)
- ❤️ Wishlist

---

## 🚀 **Quick Start**

### Prerequisites
- PHP 8.2+
- Composer
- SQLite extension enabled

### Installation

```bash
# Clone repository
git clone https://github.com/gtkrshnaaa/laravelcatashop.git
cd laravelcatashop

# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Create database & run migrations
touch database/database.sqlite
php artisan migrate:fresh --seed

# Create storage link
php artisan storage:link

# Start development server
php artisan serve
```

Visit: `http://localhost:8000`

---

## 🔑 **Default Credentials**

### Admin Panel (`/admin/login`)
- **Email:** admin@laravelcatashop.test
- **Password:** password

### Customer Account (`/customer/login`)
- **Email:** customer@example.com
- **Password:** password

---

## 📊 **Database Schema**

**18 Tables Total:**

**Core E-Commerce:**
- `users` - Admin accounts
- `categories` - Product categories
- `products` - Product catalog
- `transactions` - Customer orders
- `transaction_items` - Order line items

**Customer System:**
- `customers` - Customer accounts
- `customer_addresses` - Delivery addresses

**Reviews & Ratings:**
- `product_reviews` - Customer reviews

**Inventory:**
- `stock_logs` - Stock change history

**Promotions:**
- `coupons` - Discount codes
- `coupon_usages` - Coupon tracking

**CMS:**
- `posts` - Blog posts
- `pages` - Static pages
- `banners` - Homepage sliders

**System:**
- `wishlist` - Customer wishlists
- `password_reset_tokens`
- `sessions`
- `cache`

---

## 🛠️ **Tech Stack**

**Backend:**
- Laravel 11.x
- SQLite (WAL mode)
- PHP 8.2+

**Frontend:**
- Blade Templates
- Tailwind CSS (CDN)
- Alpine.js

**Architecture:**
- Monolithic MVC
- Session-based auth
- Multi-guard authentication

---

## 📁 **Project Structure**

```
laravelcatashop/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── Customer/       # Customer area controllers
│   │   └── Public/         # Storefront controllers
│   └── Models/             # Eloquent models (15+)
├── database/
│   ├── migrations/         # 20+ database migrations
│   └── seeders/            # Demo data seeders
├── resources/views/
│   ├── admin/              # Admin panel views
│   ├── customer/           # Customer dashboard views
│   ├── public/             # Storefront views
│   └── layouts/            # Base layouts
└── routes/web.php          # Application routes
```

---

## 🎨 **Key Features Explained**

### **Unique Payment Code**
Every order gets a unique 3-digit code (100-999) added to the total amount. This helps admin identify payments quickly without complex payment gateway integration.

**Example:**
- Subtotal: Rp 125,000
- Unique Code: +347
- **Total to Pay: Rp 125,347**

### **Multi-Authentication**
Separate authentication guards for admin and customers:
- **Admin Guard:** `/admin/*` routes
- **Customer Guard:** `/customer/*` routes
- **Guest:** Public storefront

### **Stock Control**
Products can have stock management enabled/disabled:
- Real-time stock validation
- Stock deduction on checkout
- Stock change logging
- Low stock alerts

### **Review System**
- Customers & guests can submit reviews
- 1-5 star rating
- Optional review images (max 3)
- Admin moderation (approve/reject)
- Helpful votes

---

## 📖 **Usage Guide**

### **Admin Workflow**
1. Login to admin panel
2. Create categories
3. Add products with images
4. Monitor orders
5. Update order status
6. Moderate reviews

### **Customer Workflow**
1. Browse catalog
2. Add to cart
3. Checkout (guest or logged in)
4. Receive invoice with payment instructions
5. Contact admin via WhatsApp
6. Leave product review

### **Payment Methods**
- **Bank Transfer**: Customer transfers exact amount, sends proof
- **COD**: Cash on delivery, pay when product arrives

---

## 🔧 **Configuration**

### Environment Variables
```env
APP_NAME="LaravelCataShop"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite
```

### Cache Configuration
```bash
# Cache routes & config for production
php artisan route:cache
php artisan config:cache
php artisan view:cache
```

---

## 🧪 **Testing**

```bash
# Fresh database with sample data
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear
```

---

## 📦 **Deployment**

### Requirements
- PHP 8.2+ with required extensions
- Web server (Apache/Nginx)
- Composer

### Steps
1. Clone to server
2. Run `composer install --optimize-autoloader --no-dev`
3. Copy `.env.example` to `.env`
4. Set `APP_ENV=production` and `APP_DEBUG=false`
5. Generate key: `php artisan key:generate`
6. Run migrations: `php artisan migrate --force`
7. Cache config: `php artisan config:cache`
8. Set proper permissions on `storage` and `bootstrap/cache`

---

## 🤝 **Contributing**

This is a personal project demonstrating Laravel best practices. Feel free to fork and customize for your needs.

---

## 📄 **License**

MIT License - free to use for personal and commercial projects.

---

## 📞 **Support**

For questions or issues:
- Open an issue on GitHub
- Contact: gtkrshnaaa@gmail.com

---

## 🙏 **Credits**

Built with ❤️ using:
- [Laravel](https://laravel.com/)
- [Tailwind CSS](https://tailwindcss.com/)
- [Alpine.js](https://alpinejs.dev/)

---

**Made with Laravel 11.x** | **2026**
