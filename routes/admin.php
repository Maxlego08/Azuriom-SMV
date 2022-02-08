<?php

use Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin\AdminController;
use Azuriom\Plugin\ServeurMinecraftVote\Controllers\Admin\WebhookRewardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your plugin. These
| routes are loaded by the RouteServiceProvider of your plugin within
| a group which contains the "web" middleware group and your plugin name
| as prefix. Now create something great!
|
*/

Route::get('/', [AdminController::class, 'index'])->name('index');
Route::post('/store', [AdminController::class, 'store'])->name('store');
Route::resource('rewards', WebhookRewardController::class)->except(['show', 'index']);
