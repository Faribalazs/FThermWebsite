# FTHERM Website - Modern Laravel Application

A modern, production-ready Laravel 12 application for FTHERM - a professional HVAC solutions company. This application features a public website, admin panel, and multilingual support (English, Serbian, Hungarian).

## 🎨 Design Features

- **Modern Industrial Aesthetic**: Clean, professional design suitable for HVAC/engineering company
- **Color Palette**: 
  - Primary: Blue tones (#0ea5e9)
  - Industrial: Dark grays and slate colors
  - Accent: Amber/orange highlights
- **Responsive Design**: Fully responsive, mobile-first approach
- **Smooth Transitions**: Hover effects, scaling, and micro-animations
- **Clean Typography**: Large, readable fonts with clear hierarchy

## 🚀 Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade + Tailwind CSS
- **Authentication**: Laravel Breeze
- **Database**: MySQL
- **Build Tools**: Vite

## 📦 Features

### Public Website

#### Homepage
- **Hero Section**: Large industrial background with strong headline and CTA
- **Services Section**: Grid layout showcasing HVAC services
- **Featured Products**: Preview of products from database
- **Why Choose Us**: Feature blocks highlighting company strengths
- **Contact Form**: Inquiry form with validation

#### Shop/Products
- **Product Listing**: Grid view with filters by category
- **Product Details**: 
  - Image gallery
  - Technical specifications
  - Price information
  - PDF download (optional)
  - Inquiry button
- **Related Products**: Suggestions based on category

#### Multilingual Support
- Languages: English (en), Serbian (sr), Hungarian (hu)
- Language switcher in navigation
- All content translatable via admin panel

### Admin Panel (`/admin`)

#### Dashboard
- Statistics cards (products, services, inquiries)
- Recent inquiries table
- Quick action links

#### Features
- **Services Management**: CRUD operations for services
- **Product Categories**: Manage product categories
- **Products Management**: 
  - Add/edit products with multilingual content
  - Image gallery management
  - PDF upload
  - Technical specifications
  - Price management
- **Inquiries**: View and manage customer inquiries
- **Homepage Content**: Edit hero section and other homepage content

## 🗂 Database Structure

### Tables
- `users` - Admin users with authentication
- `services` - Company services (multilingual)
- `product_categories` - Product categories (multilingual)
- `products` - Products with details (multilingual)
- `product_images` - Product image gallery
- `inquiries` - Customer contact form submissions
- `homepage_contents` - Editable homepage content (multilingual)

### Multilingual Implementation
- JSON columns store translations: `{en: "...", sr: "...", hu: "..."}`
- Helper function `translate()` automatically retrieves correct language
- Fallback to English if translation missing

## 🛠 Installation

### Prerequisites
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL

### Setup Steps

1. **Install Dependencies**
```bash
composer install
npm install
```

2. **Environment Configuration**
```bash
cp .env.example .env
php artisan key:generate
```

3. **Configure Database**
Edit `.env` file:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

4. **Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

This creates:
- Admin user: `admin@ftherm.rs` / `password`
- Sample homepage content

5. **Build Frontend Assets**
```bash
npm run build
```

For development:
```bash
npm run dev
```

6. **Start Application**
```bash
php artisan serve
```

Access at: `http://localhost:8000`
Admin panel: `http://localhost:8000/admin`

7. **Storage Setup**
```bash
php artisan storage:link
```

## 🔐 Default Credentials

**Admin Panel Access**
- Email: `admin@ftherm.rs`
- Password: `password`

**⚠️ IMPORTANT**: Change the default admin password after first login!

## 📁 Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/          # Admin panel controllers
│   │   ├── HomeController.php
│   │   ├── ShopController.php
│   │   └── ContactController.php
│   └── Middleware/
│       ├── AdminMiddleware.php
│       └── SetLocale.php
├── Models/                 # Eloquent models
└── Helpers.php            # Helper functions (translate, etc.)

resources/
├── views/
│   ├── layouts/
│   │   ├── admin.blade.php    # Admin layout
│   │   └── public.blade.php   # Public layout
│   ├── admin/                 # Admin views
│   ├── shop/                  # Shop views
│   └── home.blade.php         # Homepage
└── css/
    └── app.css

routes/
└── web.php                # All routes

database/
├── migrations/            # Database migrations
└── seeders/              # Database seeders
```

## 🎯 Key Features Implementation

### Multilingual System
```php
// Using helper function in views
{{ translate($product->name) }}

// Storing multilingual data
$product->name = [
    'en' => 'Heat Pump',
    'sr' => 'Toplotna Pumpa',
    'hu' => 'Hőszivattyú'
];
```

### Language Switching
Language persisted in session. Users can switch via nav buttons or URL parameter `?lang=en|sr|hu`

### Image Upload
Configure storage for product images:
```php
// In admin product controller
$path = $request->file('image')->store('products', 'public');
```

### Admin Authorization
```php
// Middleware checks if user is admin
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});
```

## 🎨 Customization

### Colors
Edit `tailwind.config.js`:
```javascript
colors: {
    primary: { ... },      // Main brand color
    industrial: { ... },   // Dark/gray tones
    accent: { ... }        // Highlight color
}
```

### Homepage Content
Edit via admin panel:
- `/admin/homepage-contents`
- Or directly in database `homepage_contents` table

### Services & Products
All manageable via admin panel at `/admin`

## 🔧 Development

### Running Development Server
```bash
# Terminal 1 - Laravel
php artisan serve

# Terminal 2 - Vite (Hot reload)
npm run dev
```

### Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

## 📝 Adding New Content

### Add Service
1. Go to `/admin/services`
2. Click "Add New Service"
3. Fill in all three languages
4. Set order and active status

### Add Product
1. Go to `/admin/products`
2. Click "Add New Product"
3. Fill multilingual fields
4. Upload images
5. Optional: Upload PDF, add technical specs

### Add Category
1. Go to `/admin/product-categories`
2. Create category with translations
3. Assign products to category

## 🚀 Production Deployment

1. **Environment**
```bash
APP_ENV=production
APP_DEBUG=false
```

2. **Optimize**
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

3. **Security**
- Change default admin password
- Set strong `APP_KEY`
- Configure proper `.env` values
- Set correct file permissions (755 for directories, 644 for files)
- Configure SSL certificate

4. **Server Requirements**
- PHP 8.2+
- MySQL 5.7+ / MariaDB 10.3+
- Apache/Nginx with proper rewrite rules
- Composer
- Node.js (for builds)

## 🆘 Troubleshooting

### Storage not working
```bash
php artisan storage:link
chmod -R 775 storage bootstrap/cache
```

### Assets not loading
```bash
npm run build
php artisan view:clear
```

### Database errors
```bash
php artisan migrate:fresh --seed
```

### Permission denied
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

## 📞 Support

For issues or questions about FTHERM company:
- Phone: 064 139 1360
- Email: farkas.tibor@ftherm.rs

## 📄 License

This project is proprietary software for FTHERM.

---

**Built with ❤️ for FTHERM - Professional HVAC Solutions**
