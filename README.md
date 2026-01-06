# LaravelCataShop

**Simple E-Commerce Solution with Laravel 11 + SQLite**

A production-ready e-commerce monolith built with Laravel's native features, demonstrating clean architecture without external dependencies. Features session-based cart, manual payment verification, and complete order management.

---

## 🎯 Philosophy: "Digital Ledger, Manual Trust"

This application acts as a digital accountant that records orders while money flows directly P2P (peer-to-peer), keeping seller profits 100% intact without payment gateway fees.

## ✨ Features

### Public Storefront
- 🏠 **Homepage** with featured categories and latest products
- 📦 **Product Catalog** with search and category filters
- 🛒 **Session-Based Shopping Cart** (no database overhead)
- ✅ **Checkout System** with customer info and payment selection
- 📄 **Invoice Generation** with unique payment codes
- 🌙 **Dark Mode Support**

### Admin Panel
- 📊 **Dashboard** with key metrics (cached for performance)
- 🏷️ **Category Management** (CRUD with product count)
- 📸 **Product Management** (CRUD with multi-image upload)
- 💰 **Transaction Management** with status tracking
- 🔐 **Authentication** for admin access
- 🎨 **Dark Mode** throughout admin interface

### Technical Highlights
- **Zero External Dependencies** (pure Laravel + Tailwind CDN)
- **SQLite with WAL Mode** for concurrent access
- **Real-Time Stock Validation** during checkout
- **Unique Code System** (100-999) for payment verification
- **Audit Trail** via `status_history` JSON column
- **Price Locking** in transaction items for historical accuracy

---

## 🚀 Quick Start

### Requirements
- PHP 8.2+
- Composer
- SQLite3 extension
- GD extension (for image handling)

### Installation

1. **Clone the repository**
```bash
git clone <repository-url>
cd laravelcatashop
```

2. **Install dependencies**
```bash
composer install
```

3. **Setup environment**
```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure database** (`.env` file already set to SQLite)
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

5. **Create database file**
```bash
touch database/database.sqlite
```

6. **Run migrations and seeders**
```bash
php artisan migrate:fresh --seed
```

7. **Create storage link**
```bash
php artisan storage:link
```

8. **Start development server**
```bash
php artisan serve
```

9. **Access the application**
- Public: http://localhost:8000
- Admin: http://localhost:8000/admin/login

### Default Admin Credentials
```
Email: admin@laravelcatashop.test
Password: password
```

---

## 📁 Project Structure (Scope-First)

```
app/Http/Controllers/
├── Admin/
│   ├── Auth/
│   │   └── LoginController.php
│   ├── Catalog/
│   │   ├── CategoryController.php
│   │   └── ProductController.php
│   ├── Order/
│   │   └── TransactionController.php
│   └── DashboardController.php
└── Public/
    ├── CartController.php
    ├── CatalogController.php
    ├── CheckoutController.php
    ├── HomeController.php
    ├── InvoiceController.php
    └── ProductController.php

database/
├── migrations/
│   ├── create_categories_table.php
│   ├── create_products_table.php
│   ├── create_transactions_table.php
│   └── create_transaction_items_table.php
└── seeders/
    ├── CategorySeeder.php
    └── ProductSeeder.php

resources/views/
├── layouts/
│   ├── admin.blade.php
│   └── public.blade.php
├── admin/
│   ├── auth/
│   ├── catalog/
│   ├── dashboard/
│   └── order/
└── public/
    ├── cart/
    ├── catalog/
    ├── checkout/
    ├── home/
    ├── invoice/
    └── product/
```

---

## 🧪 Testing Guide

### 1. Test Public Flow
```bash
# Start server
php artisan serve

# Visit homepage
http://localhost:8000

# Browse catalog
http://localhost:8000/catalog

# View product detail (click any product)

# Add to cart (adjust quantity and click "Add to Cart")

# View cart
http://localhost:8000/cart

# Proceed to checkout
- Fill customer information
- Select payment method
- Click "Place Order"

# View invoice with payment instructions
```

### 2. Test Admin Panel
```bash
# Login to admin
http://localhost:8000/admin/login
Email: admin@laravelcatashop.test
Password: password

# Navigate to Dashboard
- View metrics (products, categories, orders, revenue)
- Check recent orders

# Test Category Management
- Create new category
- Edit existing category
- Check product count before delete

# Test Product Management
- Create product with images
- Update product (add/remove images)
- Test stock control toggle
- Delete product

# Test Transaction Management
- View all transactions
- Open transaction detail
- Update status (Unpaid → Paid → Shipped → Completed)
- Observe status change in list
```

### 3. Test Cart Features
```bash
# Add multiple products to cart
# Update quantities in cart
# Remove items from cart
# Clear entire cart
# Test stock validation (try to add more than available stock)
```

---

## 🎨 Design System

### Color Palette
**Light Mode:**
- Background: `#ffffff`
- Surface: `#ffffff`
- Border: `#e4e4e7`
- Primary: `#18181b`
- Secondary: `#71717a`

**Dark Mode:**
- Background: `#0a0a0a`
- Surface: `#171717`
- Border: `#262626`
- Primary: `#ededed`
- Secondary: `#a1a1aa`

### Typography
- Sans: Inter (Google Fonts)
- Mono: JetBrains Mono (for prices, codes)

---

## 📊 Database Schema

### Categories
- `id`, `name`, `slug` (unique, indexed)
- `description`, `is_featured`
- `timestamps`

### Products
- `id`, `category_id`, `name`, `slug` (unique, indexed)
- `sku` (unique), `description`, `price`, `stock`
- `stock_control` (boolean), `is_active` (boolean)
- `images` (JSON array), `timestamps`

### Transactions
- `id`, `invoice_code` (unique)
- `customer_info` (JSON: name, whatsapp, address)
- `payment_method` (enum), `unique_code` (100-999)
- `amount_subtotal`, `amount_total`
- `status` (enum: unpaid, paid, shipped, completed, cancelled)
- `status_history` (JSON audit trail)
- `notes`, `timestamps`

### Transaction Items
- `id`, `transaction_id`, `product_id`
- `product_snapshot` (JSON: name, sku)
- `quantity`, `price_locked`, `subtotal`
- `timestamps`

---

## 🔒 Security Features

- CSRF Protection on all forms
- Admin authentication middleware
- Input validation on all user inputs
- Database transactions for checkout
- Stock locking during checkout (`lockForUpdate()`)
- Password hashing (bcrypt)

---

## 🚢 Deployment

### Requirements
- VPS/Shared hosting with PHP 8.2+
- SQLite3 support
- 512MB RAM minimum

### Steps
1. Upload project files
2. Run `composer install --optimize-autoloader --no-dev`
3. Set `.env` to production values
4. Run `php artisan config:cache`
5. Run `php artisan route:cache`
6. Run `php artisan view:cache`
7. Set proper permissions for `storage/` and `database/`

---

## 📝 Development Standards

This project follows **LARAVELDEVCONF** standards:
- **Scope-First Directory Structure** for controllers
- **One-Line Rule** for routes (no closures)
- **English** for all code (variables, functions, comments)
- **Bahasa Indonesia** for UI text (can be changed)
- Consistent naming conventions
- No external packages (zero-dependency policy)

---

## 🤝 Contributing

This is an educational/reference project. Feel free to fork and adapt for your needs.

---

## 📄 License

Open source. Use freely for learning and commercial projects.

---

## 🎓 Learning Resources

This project demonstrates:
- Clean Laravel architecture without bloat
- Session-based cart implementation
- Multi-image upload with Laravel Storage
- JSON column usage for flexible data
- Database transactions and locking
- Eloquent relationships and scopes
- Blade components and layouts
- Tailwind CSS with dark mode
- Alpine.js for interactivity

---

**Built with ❤️ using pure Laravel + SQLite**
