<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\ProductCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\InquiryController;
use App\Http\Controllers\Admin\HomepageContentController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Auth Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Routes
Route::middleware(['auth:admin', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::post('logout', [App\Http\Controllers\Admin\Auth\LoginController::class, 'destroy'])->name('logout');
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // Services Management
    Route::resource('services', ServiceController::class);
    
    // Product Categories Management
    Route::resource('product-categories', ProductCategoryController::class);
    
    // Products Management
    Route::resource('products', ProductController::class);
    Route::post('products/{product}/images', [ProductController::class, 'uploadImage'])->name('products.images.upload');
    Route::delete('products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.images.delete');
    
    // Inquiries Management
    Route::resource('inquiries', InquiryController::class)->only(['index', 'show', 'destroy']);
    Route::patch('inquiries/{inquiry}/mark-read', [InquiryController::class, 'markAsRead'])->name('inquiries.mark-read');
    
    // Homepage Content Management
    Route::resource('homepage-contents', HomepageContentController::class);
    
    // Worker Management
    Route::resource('workers', App\Http\Controllers\Admin\WorkerController::class);
    Route::patch('workers/{worker}/ban', [App\Http\Controllers\Admin\WorkerController::class, 'ban'])->name('workers.ban');
    Route::patch('workers/{worker}/unban', [App\Http\Controllers\Admin\WorkerController::class, 'unban'])->name('workers.unban');

    // Settings
    Route::get('settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');
});

// Worker Routes
Route::middleware(['auth:worker', 'worker'])->prefix('worker')->name('worker.')->group(function () {
    Route::post('logout', [App\Http\Controllers\Worker\Auth\LoginController::class, 'destroy'])->name('logout');
    
    // No permissions page (accessible to all workers)
    Route::get('/no-permissions', function () {
        return view('worker.no-permissions');
    })->name('no-permissions');
    
    // Dashboard - requires dashboard permission
    Route::middleware('worker.permission:dashboard')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Worker\DashboardController::class, 'index'])->name('dashboard');
    });

    // Internal Products (Worker Only) - requires products permission
    Route::middleware('worker.permission:products')->group(function () {
        Route::resource('products', App\Http\Controllers\Worker\InternalProductController::class);
    });

    // Work Orders (Radni Nalozi) - requires work_orders permission
    Route::middleware('worker.permission:work_orders')->group(function () {
        Route::resource('work-orders', App\Http\Controllers\Worker\WorkOrderController::class)->except(['edit', 'update']);
        Route::post('work-orders/{workOrder}/invoice', [App\Http\Controllers\Worker\WorkOrderController::class, 'generateInvoice'])->name('work-orders.invoice.generate');
        Route::get('work-orders/{workOrder}/invoice', [App\Http\Controllers\Worker\WorkOrderController::class, 'showInvoice'])->name('work-orders.invoice');
        Route::get('work-orders/{workOrder}/invoice/download', [App\Http\Controllers\Worker\WorkOrderController::class, 'downloadInvoice'])->name('work-orders.invoice.download');
    });

    // Inventory Replenishment (Dopuna Zaliha) - requires inventory permission
    Route::middleware('worker.permission:inventory')->group(function () {
        Route::get('inventory', [App\Http\Controllers\Worker\InventoryReplenishmentController::class, 'index'])->name('inventory.index');
        Route::post('inventory/{product}/add', [App\Http\Controllers\Worker\InventoryReplenishmentController::class, 'update'])->name('inventory.add');
        Route::post('inventory/{product}/set', [App\Http\Controllers\Worker\InventoryReplenishmentController::class, 'set'])->name('inventory.set');
    });

    // Invoices - requires invoices permission
    Route::middleware('worker.permission:invoices')->group(function () {
        Route::get('invoices', [App\Http\Controllers\Worker\InvoiceController::class, 'index'])->name('invoices.index');
    });

    // Activity Logs - requires activity_logs permission
    Route::middleware('worker.permission:activity_logs')->group(function () {
        Route::get('activity-logs', [App\Http\Controllers\Worker\ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});

// Auth Routes for Admin/Worker
Route::prefix('admin')->name('admin.')->middleware('guest:admin')->group(function () {
    Route::get('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'create'])->name('login');
    Route::post('login', [App\Http\Controllers\Admin\Auth\LoginController::class, 'store']);
});

Route::prefix('worker')->name('worker.')->middleware('guest:worker')->group(function () {
    Route::get('login', [App\Http\Controllers\Worker\Auth\LoginController::class, 'create'])->name('login');
    Route::post('login', [App\Http\Controllers\Worker\Auth\LoginController::class, 'store']);
});

require __DIR__.'/auth.php';
