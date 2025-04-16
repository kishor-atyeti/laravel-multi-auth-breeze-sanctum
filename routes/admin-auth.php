<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('admin.register');

    Route::post('register', [RegisteredUserController::class, 'store']);

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('admin.logout');

    Route::get('dashboard', function () {
        return view('admin.dashboard');
    })->middleware(['verified'])->name('admin.dashboard');

    // Permissions
    Route::get('permissions', [PermissionController::class, 'index'])->name('admin.permissions.index');
    Route::get('permissions/create', [PermissionController::class, 'create'])->name('admin.permissions.create');
    Route::post('permissions', [PermissionController::class, 'store'])->name('admin.permissions.store');
    Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('admin.permissions.show');
    Route::get('permissions/{permission}/edit', [PermissionController::class, 'edit'])->name('admin.permissions.edit');
    Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('admin.permissions.update');
    Route::get('permissions/{id}/delete', [PermissionController::class, 'destroy'])->name('admin.permissions.destroy');

    // Roles
    Route::get('roles', [RoleController::class, 'index'])->name('admin.roles.index');
    Route::get('roles/create', [RoleController::class, 'create'])->name('admin.roles.create')->middleware('permission:Role: Create');
    Route::post('roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('admin.roles.show');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('admin.roles.update');
    Route::get('roles/{roldId}/delete', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
    Route::get('roles/{roleId}/give-permission', [RoleController::class, 'addPermissionToRole']);
    Route::put('roles/{roleId}/give-permission', [RoleController::class, 'givePermissionToRole']);

    // Administrator
    Route::get('administrator', [AdminController::class, 'index'])->name('admin.administrator.index');
    Route::get('administrator/create', [AdminController::class, 'create'])->name('admin.administrator.create');
    Route::post('administrator', [AdminController::class, 'store'])->name('admin.administrator.store');
    Route::get('administrator/{administrator}', [AdminController::class, 'show'])->name('admin.administrator.show');
    Route::get('administrator/{administrator}/edit', [AdminController::class, 'edit'])->name('admin.administrator.edit');
    Route::put('administrator/{administrator}', [AdminController::class, 'update'])->name('admin.administrator.update');
    Route::get('administrator/{id}/delete', [AdminController::class, 'destroy'])->name('admin.administrator.destroy');
});
