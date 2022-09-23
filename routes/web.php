<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [AuthController::class,"loginView"]);
Route::get('/login', [AuthController::class,"loginView"]);
Route::get('/register', [AuthController::class,"registerView"]);
Route::post('/do-login', [AuthController::class,"doLogin"]);
Route::post('/do-register', [AuthController::class,"doRegister"]);
Route::get('/dashboard', [AuthController::class,"dashboard"]);
Route::get('/logout', [AuthController::class,"logout"]);


///  vender 
Route::get('/Vendor-List', [VendorController::class, 'index']);
Route::post('/store', [VendorController::class, 'store'])->name('store');
Route::get('/fetchAll', [VendorController::class, 'fetchAll'])->name('fetchAll');
Route::delete('/delete', [VendorController::class, 'delete'])->name('delete');
Route::get('/edit', [VendorController::class, 'edit'])->name('edit');
Route::post('/update', [VendorController::class, 'update'])->name('update');

// role
Route::get('/Role-List', [RoleController::class, 'index']);
Route::post('/storeRole', [RoleController::class, 'storeRole'])->name('storeRole');
Route::get('/fetchAllRole', [RoleController::class, 'fetchAllRole'])->name('fetchAllRole');
Route::delete('/deleteRole', [RoleController::class, 'deleteRole'])->name('deleteRole');
Route::get('/editRole', [RoleController::class, 'editRole'])->name('editRole');
Route::post('/updateRole', [RoleController::class, 'updateRole'])->name('updateRole');