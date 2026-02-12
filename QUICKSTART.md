# 🚀 FTHERM Website - Quick Start Guide

This guide will help you get the FTHERM website up and running quickly.

## Step 1: Database Configuration

1. Open your `.env` file
2. Update these database settings:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=FThermNewSite
DB_USERNAME=root
DB_PASSWORD=your_password
```

## Step 2: Initialize Database

Run this command to create all tables and seed initial data:

```bash
php artisan migrate:fresh --seed
```

This will create:
- ✅ All database tables
- ✅ Admin user (admin@ftherm.rs / password)
- ✅ Sample homepage content

## Step 3: Link Storage

```bash
php artisan storage:link
```

This allows uploaded images to be publicly accessible.

## Step 4: Build Frontend Assets

```bash
npm run build
```

Or for development with hot reload:
```bash
npm run dev
```

## Step 5: Start the Application

```bash
php artisan serve
```

The application will be available at: **http://localhost:8000**

## Access Points

### Public Website
- Homepage: `http://localhost:8000`
- Products: `http://localhost:8000/shop`

### Admin Panel
- URL: `http://localhost:8000/admin`
- Email: `admin@ftherm.rs`
- Password: `password`

**⚠️ Important**: Change the admin password after first login!

## Next Steps

### 1. Add Services
1. Login to admin panel
2. Go to "Services"
3. Click "Add New Service"
4. Fill in English, Serbian, and Hungarian translations
5. Save

### 2. Add Product Categories
1. Go to "Categories"
2. Create categories (e.g., "Heat Pumps", "Air Conditioning")
3. Add translations for each language

### 3. Add Products
1. Go to "Products"
2. Click "Add New Product"
3. Fill in all fields
4. Upload product images
5. Optional: Upload PDF brochure
6. Save

### 4. Customize Homepage
1. Go to "Homepage Content"
2. Edit hero title, subtitle, and CTA text
3. Update for all languages

### 5. Test Contact Form
1. Visit homepage
2. Scroll to contact section
3. Submit a test inquiry
4. Check in Admin > Inquiries

## Language Switching

Users can switch languages by:
- Clicking EN / SR / HU buttons in the navigation
- Adding `?lang=en` (or sr/hu) to any URL

## Folder Structure for Uploads

```
storage/app/public/
├── products/          # Product images
└── pdfs/             # Product PDF files
```

## Common Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear

# Rebuild database (⚠️ deletes all data)
php artisan migrate:fresh --seed

# Rebuild frontend assets
npm run build

# Check routes
php artisan route:list
```

## Troubleshooting

### "Storage not found" error
```bash
php artisan storage:link
```

### Assets not loading
```bash
npm run build
php artisan view:clear
```

### Permission errors
```bash
chmod -R 775 storage bootstrap/cache
```

### Database connection error
- Check MySQL is running
- Verify credentials in `.env`
- Create database if it doesn't exist

## Production Checklist

Before deploying to production:

- [ ] Change admin password
- [ ] Set `APP_ENV=production` in `.env`
- [ ] Set `APP_DEBUG=false` in `.env`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build`
- [ ] Set up SSL certificate
- [ ] Configure proper backups
- [ ] Set secure file permissions

## Need Help?

Check the main [README.md](README.md) for detailed documentation.

Contact FTHERM:
- Phone: 064 139 1360
- Email: farkas.tibor@ftherm.rs

---

**Happy Building! 🎉**
