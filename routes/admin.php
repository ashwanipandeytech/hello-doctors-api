<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ImageUploadController;
use App\Http\Controllers\Admin\ImageValidatorController;
use App\Http\Controllers\Admin\ResourceattributesController;
use App\Http\Controllers\Admin\UploadfilesController;


Route::prefix('admin')->group(function () {
        Route::post('/login', [AdminUserController::class, 'login']);      
        Route::post('/create', [AdminUserController::class, 'create']);
        Route::post('/productdetails', [ProductController::class, 'getdetails']);
        Route::post('/producttree', [CategoryController::class, 'producttree']);
        Route::post('/productlist', [ProductController::class, 'productlist']);
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Authentication required for all routes under 'admin' prefix
    Route::post('/logout', [AdminUserController::class, 'logout']);
    Route::post('/getstatename', [AdminUserController::class, 'getUserPermissions']);
    Route::post('/users', [AdminUserController::class, 'create']);
    Route::put('/users/{user}', [AdminUserController::class, 'update']);
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy']);

    Route::post('/roles', [RoleController::class, 'create']);
    Route::put('/roles/{role}', [RoleController::class, 'update']);
    Route::delete('/roles/{role}', [RoleController::class, 'destroy']);

    Route::post('/assign-roles', [AdminUserController::class, 'assignRoles']);
    Route::post('/assign-permissions', [RoleController::class, 'assignPermissions']);
    
    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'index']);
        Route::post('/tree', [CategoryController::class, 'tree']);
        Route::post('/add', [CategoryController::class, 'store']);
        Route::post('/detail', [CategoryController::class, 'show']);
        Route::post('/update', [CategoryController::class, 'update']);
        Route::post('/delete', [CategoryController::class, 'destroy']);
        Route::post('/tags', [CategoryController::class, 'listTags']);
    });

    Route::prefix('products')->group(function () {
        Route::post('/', [ProductController::class, 'index']);
        Route::post('/add', [ProductController::class, 'store']);
        Route::post('/detail', [ProductController::class, 'show']);
        Route::post('/update', [ProductController::class, 'update']);
        Route::post('/destroy', [ProductController::class, 'destroy']);
        Route::post('/tags', [ProductController::class, 'listTags']);       
    });

     Route::prefix('attributes')->group(function () {
        Route::post('/', [ResourceattributesController::class, 'index']);
        Route::post('/add', [ResourceattributesController::class, 'create']);
        Route::post('/detail', [ResourceattributesController::class, 'show']);
        Route::post('/update', [ResourceattributesController::class, 'update']);
        Route::post('/delete', [ResourceattributesController::class, 'destroy']);
    });

    
    Route::post('/upload-image', [ImageUploadController::class, 'uploadImage']);
    Route::post('/upload-video', [ProductController::class, 'uploadVideo']);
    Route::post('/getimagevalidations', [ImageValidatorController::class, 'get']);
    Route::post('/bulk-upload', [ProductController::class, 'bulkUploadProducts']);
    Route::post('/sync-json', [UploadfilesController::class, 'homejson']);
    Route::post('/upload-system-images', [UploadfilesController::class, 'systemimages']);
    Route::post('/get-system-images', [UploadfilesController::class, 'getsystemimages']);
    Route::post('/system-get-jsons', [UploadfilesController::class, 'getsystemjsons']);

});


