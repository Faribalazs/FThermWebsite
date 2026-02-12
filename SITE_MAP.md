# 🗺️ FTHERM Website - Site Map & Structure

## 🌐 Public Website Routes

```
/ (Home)
├── Hero Section
├── Services Section
├── Featured Products
├── Why Choose Us
├── Contact Form
└── Footer

/shop (Products)
├── Category Filter Sidebar
├── Product Grid
└── Pagination

/shop/{product-slug} (Product Detail)
├── Image Gallery
├── Product Info
├── Technical Specs
├── PDF Download
├── Inquiry Form
└── Related Products
```

## 🔐 Admin Panel Routes

```
/admin (Dashboard)
├── Statistics Cards
│   ├── Total Products
│   ├── Total Services
│   ├── Total Inquiries
│   └── Unread Inquiries
├── Recent Inquiries Table
└── Quick Actions

/admin/services
├── /admin/services (List)
├── /admin/services/create (Add New)
└── /admin/services/{id}/edit (Edit)

/admin/product-categories
├── /admin/product-categories (List)
├── /admin/product-categories/create (Add New)
└── /admin/product-categories/{id}/edit (Edit)

/admin/products
├── /admin/products (List)
├── /admin/products/create (Add New)
├── /admin/products/{id}/edit (Edit)
└── /admin/products/{id}/images (Upload Images)

/admin/inquiries
├── /admin/inquiries (List)
└── /admin/inquiries/{id} (View Details)

/admin/homepage-contents
├── /admin/homepage-contents (List)
└── /admin/homepage-contents/{id}/edit (Edit)
```

## 📊 Database Tables Relationship Map

```
users
└── has many → (none currently, extendable)

services
└── standalone table (no relations)

product_categories
└── has many → products

products
├── belongs to → product_categories
└── has many → product_images

product_images
└── belongs to → products

inquiries
└── standalone table (no relations)

homepage_contents
└── standalone table (key-value store)
```

## 🎨 Component Hierarchy

### Public Layout
```
layouts/public.blade.php
├── Navigation Bar
│   ├── Logo (FTHERM)
│   ├── Menu Items (Home, Services, Products, Contact)
│   └── Language Switcher (EN, SR, HU)
├── Main Content (@yield)
└── Footer
    ├── Company Info
    ├── Quick Links
    ├── Contact Details
    └── Copyright
```

### Admin Layout
```
layouts/admin.blade.php
├── Sidebar
│   ├── Logo (FTHERM Admin)
│   └── Navigation Menu
│       ├── Dashboard
│       ├── Services
│       ├── Categories
│       ├── Products
│       ├── Inquiries
│       └── Homepage Content
├── Top Bar
│   ├── Page Title
│   ├── View Site Link
│   ├── User Name
│   └── Logout
└── Main Content (@yield)
    ├── Success/Error Messages
    └── Page Content
```

## 🎯 User Flows

### Visitor Journey (Public)
```
Landing on Homepage
├─→ Browse Services
├─→ View Featured Products
│   └─→ Click Product → Product Detail
│       ├─→ View Images
│       ├─→ Download PDF
│       └─→ Submit Inquiry
├─→ Browse Full Product Catalog
│   ├─→ Filter by Category
│   └─→ View Product Details
└─→ Contact Form
    └─→ Submit Inquiry
```

### Admin Journey
```
Login to Admin Panel
└─→ Dashboard Overview
    ├─→ Manage Services
    │   ├─→ Create New Service
    │   │   └─→ Add EN/SR/HU content
    │   └─→ Edit Existing Service
    │
    ├─→ Manage Categories
    │   └─→ Create/Edit Categories
    │
    ├─→ Manage Products
    │   ├─→ Create New Product
    │   │   ├─→ Fill multilingual content
    │   │   ├─→ Upload images
    │   │   └─→ Upload PDF
    │   └─→ Edit Existing Product
    │
    ├─→ View Inquiries
    │   ├─→ Read messages
    │   └─→ Mark as read
    │
    └─→ Edit Homepage Content
        └─→ Update hero section
```

## 🌍 Multilingual Structure

### Content Storage Format
```json
{
    "en": "Heat Pump Installation",
    "sr": "Ugradnja Toplotnih Pumpi",
    "hu": "Hőszivattyú Telepítés"
}
```

### Language Switching Flow
```
User clicks language button (EN/SR/HU)
└─→ SetLocale Middleware
    ├─→ Validate language
    ├─→ Set app locale
    ├─→ Store in session
    └─→ Return page in new language
```

### Translation Helper Flow
```
{{ translate($product->name) }}
└─→ Get current locale
    ├─→ Extract value for locale
    ├─→ Fallback to 'en' if missing
    └─→ Return translated string
```

## 📁 File Organization

### Controllers Structure
```
app/Http/Controllers/
├── Admin/                  (Admin-only controllers)
│   ├── DashboardController
│   ├── ServiceController
│   ├── ProductCategoryController
│   ├── ProductController
│   ├── InquiryController
│   └── HomepageContentController
├── HomeController         (Public homepage)
├── ShopController         (Public shop/products)
└── ContactController      (Contact form handling)
```

### Views Structure
```
resources/views/
├── layouts/
│   ├── admin.blade.php    (Admin panel layout)
│   └── public.blade.php   (Public site layout)
├── admin/
│   ├── dashboard.blade.php
│   └── services/
│       ├── index.blade.php
│       ├── create.blade.php
│       └── edit.blade.php
├── shop/
│   ├── index.blade.php    (Product listing)
│   └── show.blade.php     (Product detail)
└── home.blade.php         (Homepage)
```

### Models Structure
```
app/Models/
├── User.php               (Admin users)
├── Service.php            (Services offered)
├── ProductCategory.php    (Product categories)
├── Product.php           (Products)
├── ProductImage.php      (Product images)
├── Inquiry.php           (Contact inquiries)
└── HomepageContent.php   (Editable homepage content)
```

## 🔄 Data Flow Examples

### Product Creation Flow
```
Admin fills form
└─→ ServiceController@store
    ├─→ Validate input
    ├─→ Create JSON for translations
    │   ├─→ title: {en, sr, hu}
    │   └─→ description: {en, sr, hu}
    ├─→ Save to database
    └─→ Redirect with success message
```

### Product Display Flow
```
User visits /shop
└─→ ShopController@index
    ├─→ Query products (with category filter)
    ├─→ Load relationships (category, images)
    ├─→ Pass to view
    └─→ shop/index.blade.php
        ├─→ Loop through products
        ├─→ Call translate() for each
        └─→ Render in current language
```

### Inquiry Submission Flow
```
User submits contact form
└─→ ContactController@store
    ├─→ Validate input
    ├─→ Create Inquiry record
    ├─→ Save to database
    └─→ Redirect with success message
        └─→ Admin sees in dashboard
```

## 🎨 Design Pattern

### Page Structure Pattern
```
┌─────────────────────────────┐
│      Navigation Bar         │ ← Sticky at top
├─────────────────────────────┤
│                             │
│      Hero Section           │ ← Dark background
│   (Large heading + CTA)     │
│                             │
├─────────────────────────────┤
│                             │
│    Section with Cards       │ ← White/gray background
│   (Grid layout, 3 cols)    │
│                             │
├─────────────────────────────┤
│                             │
│    Another Section          │ ← Alternating colors
│                             │
├─────────────────────────────┤
│                             │
│      Footer                 │ ← Dark background
│   (Links + Contact)         │
│                             │
└─────────────────────────────┘
```

### Card Component Pattern
```
┌─────────────────┐
│                 │
│     Icon/Image  │ ← Visual element
│                 │
├─────────────────┤
│   Title         │ ← Bold, large
│   Description   │ ← Gray, smaller
│   [Button]      │ ← Action (optional)
│                 │
└─────────────────┘
  ↑
  Hover: Shadow increases
         Slight scale up
```

## 🔐 Security Layers

```
Request
├─→ CSRF Token Validation
├─→ Authentication Check (for /admin)
├─→ Admin Middleware (is_admin = true)
├─→ Form Validation
└─→ Controller Action
    └─→ Database Operation
```

## 📱 Responsive Breakpoints

```
Mobile First Approach

         Mobile          Tablet         Desktop        Wide
         ↓               ↓              ↓              ↓
  ────────────────────────────────────────────────────────→
  0px    sm: 640px    md: 768px    lg: 1024px    xl: 1280px

Layout:
├── < 640px:  Single column, stacked
├── 640-768px: 2 columns for some sections
├── 768-1024px: 2-3 columns, sidebar appears
└── > 1024px: Full 3-4 column grid
```

---

This map shows how everything connects and flows through the application. Use it as a reference when:
- Adding new features
- Understanding data flow
- Debugging issues
- Training new developers
- Planning enhancements

**The structure is clean, logical, and follows Laravel best practices!** 🎉
