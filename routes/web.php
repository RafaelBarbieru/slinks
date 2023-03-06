<?php

use App\Http\Controllers\BlockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\CRUDController;
use App\Models\Group;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [BlockController::class, 'show'])->name('root');
    Route::get('/new', [CRUDController::class, 'showAdd'])->name('new');
    Route::get('/modify/{id}', [CRUDController::class, 'showEdit'])->name('modify');
    Route::post('/edit/{id}', [CRUDController::class, 'edit'])->name('edit');
    Route::post('/add', [CRUDController::class, 'add']);
    Route::get('/groups/{block_id}', [CRUDController::class, 'getGroups']);
    Route::get('/remove/{id}', [CRUDController::class, 'remove'])->name('remove');
    Route::get('/up/{id}]', [CRUDController::class, 'decreaseOrder'])->name('up');
    Route::get('/down/{id}]', [CRUDController::class, 'increaseOrder'])->name('down');
    Route::post('/changeBlockOrder', [CRUDController::class, 'changeBlockOrder']);
    Route::post('/changeGroupOrder', [CRUDController::class, 'changeGroupOrder']);
    Route::post('/changeLinkOrder', [CRUDController::class, 'changeLinkOrder']);
});

Route::get('/login', [LoginController::class, 'show'])->name('login');
Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('redirect');
Route::get('/auth/callback', [LoginController::class, 'handleCallback']);
