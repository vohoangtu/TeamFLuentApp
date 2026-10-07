<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PermissionGroupController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\ThemeController;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Member Management & Multi-Project Assignments
Route::resource('members', MemberController::class);
Route::post('members/{member}/projects', [MemberController::class, 'assignProject'])->name('members.projects.store');
Route::delete('members/{member}/projects/{project}', [MemberController::class, 'unassignProject'])->name('members.projects.destroy');

// Project Management & Member Assignments
Route::resource('projects', ProjectController::class);
Route::post('projects/{project}/members', [ProjectController::class, 'assignMember'])->name('projects.members.store');
Route::delete('projects/{project}/members/{member}', [ProjectController::class, 'removeMember'])->name('projects.members.destroy');

// Team Management
Route::resource('teams', TeamController::class);

// Role Management & RBAC Permissions Matrix
Route::post('roles/matrix', [RoleController::class, 'updateMatrix'])->name('roles.matrix.update');
Route::resource('roles', RoleController::class);

// Functional Permission Groups (Nhóm Quyền Chức Năng: Dev, System, Management...)
Route::resource('permission-groups', PermissionGroupController::class)->except(['index', 'show']);

// Theme & Blade Component Showcase
Route::get('themes', [ThemeController::class, 'index'])->name('themes.index');
