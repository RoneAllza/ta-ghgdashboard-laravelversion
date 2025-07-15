<?php

use App\Models\ThingspeakChannel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerusahaanController;
use App\Http\Controllers\SensorEntryController;
use App\Http\Controllers\SumberEmisiController;
use App\Http\Controllers\MaintenancesController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UnitPelaksanaController;
use App\Http\Controllers\FuelPropertiesController;
use App\Http\Controllers\KategoriSumberController;
use App\Http\Controllers\ThingspeakChannelController;
use App\Models\KategoriSumber;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role:unit_lingkungan'])->group(function () {
    Route::get('/dashboard', [SensorEntryController::class, 'index'])->name('dashboard');
    Route::get('/', [SensorEntryController::class, 'index'])->name('home');
    Route::get('/report', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/report/create', [ReportController::class, 'create'])->name('reports.create');
    Route::get('/report/{id}', [ReportController::class, 'show'])->name('reports.show');
    Route::post('/report/create', [ReportController::class, 'store'])->name('reports.store');
    Route::get('/report-export', [ReportController::class, 'export'])->name('reports.export');
    // Route::

    Route::get('/data-teknisi', [UserController::class, 'index'])->name('teknisi.index');
    Route::get('/data-teknisi/add', [UserController::class, 'create'])->name('teknisi.add');
    Route::post('/data-teknisi/add', [UserController::class, 'store'])->name('teknisi.store');
    Route::get('/data-teknisi/edit/{id}', [UserController::class, 'edit'])->name('teknisi.edit');
    Route::patch('/data-teknisi/{id}', [UserController::class, 'update'])->name('teknisi.update');
    Route::delete('/data-teknisi/{id}', [UserController::class, 'destroy'])->name('teknisi.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/perusahaan', [PerusahaanController::class, 'index'])->name('companies.index');
    Route::get('/perusahaan/edit/{id}', [PerusahaanController::class, 'edit'])->name('companies.edit');
    Route::post('/perusahaan/edit/{id}', [PerusahaanController::class, 'update'])->name('companies.update');
    // Route::match(['put', 'patch'], '/perusahaan/edit/{id}', [PerusahaanController::class, 'update'])->name('companies.update');
    Route::match(['put', 'patch'], '/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/emisi', [SumberEmisiController::class, 'index'])->name('emisis.index');
    Route::get('/emisi/tambah', [SumberEmisiController::class, 'create'])->name('emisis.create');
    Route::post('/emisi/tambah', [SumberEmisiController::class, 'store'])->name('emisis.store');
    Route::get('/emisi/{id}', [SumberEmisiController::class, 'show'])->name('emisis.show');
    Route::get('/emisi/edit/{id}', [SumberEmisiController::class, 'edit'])->name('emisis.edit');
    Route::delete('/emisi/{id}', [SumberEmisiController::class, 'destroy'])->name('emisis.destroy');
    Route::match(['put', 'patch'], '/emisi/{id}', [SumberEmisiController::class, 'update'])->name('emisis.update');
    Route::get('/emisi-export', [SumberEmisiController::class, 'export'])->name('emisis.export');
   
    Route::get('/maintenance/add', [MaintenancesController::class, 'add'])->name('maintenances.add');
    Route::get('/maintenance/{id}', [MaintenancesController::class, 'show'])->name('maintenances.show');
    
    Route::get('/sensor', [SensorController::class, 'index'])->name('sensors.index');
    Route::get('/sensor/create', [SensorController::class, 'create'])->name('sensors.create');
    Route::post('/sensor/create', [SensorController::class, 'store'])->name('sensors.store');
    Route::get('/sensor/{id}', [SensorController::class, 'show'])->name('sensors.show');
    Route::get('/sensor/{id}/edit', [SensorController::class, 'edit'])->name('sensors.edit');
    // Route::get('/channel/add', [ThingspeakChannelController::class, 'add_channel'])->name('channel.add');
    // Route::post('/channel/add', [ThingspeakChannelController::class, 'store'])->name('channel.store');
    Route::get('/sensor/export', [SensorController::class, 'export']);
    // Route::get('/sensor', [ThingspeakChannelController::class, 'index'])->name('sensors.index');
    Route::match(['put', 'patch'], '/sensor/{id}', [SensorController::class, 'update'])->name('sensors.update');
    Route::delete('/sensor/{id}', [SensorController::class, 'destroy'])->name('sensors.destroy');
    
    Route::get('/fuel-props', [FuelPropertiesController::class, 'index'])->name('fuel_props.index');
    Route::get('/fuel-props/add', [FuelPropertiesController::class, 'addFuelProps'])->name('fuel_props.add');
    Route::post('/fuel-props/add', [FuelPropertiesController::class, 'store'])->name('fuel_props.store');
    Route::get('/fuel-props/edit/{id}', [FuelPropertiesController::class, 'editFuelProps'])->name('fuel_props.edit');
    Route::match(['put', 'patch'], '/fuel-props/{id}', [FuelPropertiesController::class, 'update'])->name('fuel_props.update');
    Route::delete('/fuel-props/{id}', [FuelPropertiesController::class, 'destroy'])->name('fuel_props.destroy');
    Route::get('/fuel-props/table', [FuelPropertiesController::class, 'index'])->name('fuel_props.table');

    Route::get('/kategori-sumber', [KategoriSumberController::class, 'index'])->name('kategori_sumber.index');
    Route::get('/kategori-sumber/add', [KategoriSumberController::class, 'add'])->name('kategori_sumber.add');
    Route::post('/kategori-sumber/add', [KategoriSumberController::class, 'store'])->name('kategori_sumber.store');
    Route::get('/kategori-sumber/edit/{id}', [KategoriSumberController::class, 'edit'])->name('kategori_sumber.edit');
    Route::match(['put', 'patch'], '/kategori-sumber/{id}', [KategoriSumberController::class, 'update'])->name('kategori_sumber.update');
    Route::delete('/kategori-sumber/{id}', [KategoriSumberController::class, 'destroy'])->name('kategori_sumber.destroy');
    Route::get('/kategori-sumber/table', [KategoriSumberController::class, 'index'])->name('kategori_sumber.table');

    Route::get('/maintenance', [MaintenancesController::class, 'index'])->name('maintenances.index');
});

Route::middleware(['auth', 'role:teknisi'])->prefix('teknisi')->group(function () {
    Route::get('/dashboard', [SensorEntryController::class, 'index'])->name('teknis.dashboard');
    Route::get('/', [SensorEntryController::class, 'index'])->name('teknis.home');
    // Route::get('/maintenance/update', [MaintenancesController::class, 'add'])->name('teknisi_maintenances.update');

    Route::get('/emisi', [SumberEmisiController::class, 'index'])->name('teknisi_emisis.index');
    Route::get('/emisi/tambah', [SumberEmisiController::class, 'create'])->name('teknisi_emisis.create');
    Route::post('/emisi/tambah', [SumberEmisiController::class, 'store'])->name('teknisi_emisis.store');
    Route::get('/emisi/{id}', [SumberEmisiController::class, 'show'])->name('teknisi_emisis.show');
    Route::get('/emisi/edit/{id}', [SumberEmisiController::class, 'edit'])->name('teknisi_emisis.edit');
    Route::delete('/emisi/{id}', [SumberEmisiController::class, 'destroy'])->name('teknisi_emisis.destroy');
    Route::match(['put', 'patch'], '/emisi/{id}', [SumberEmisiController::class, 'update'])->name('teknisi_emisis.update');
    Route::get('/emisi-export', [SumberEmisiController::class, 'export'])->name('teknisi_emisis.export');
    Route::get('/maintenance', [MaintenancesController::class, 'index'])->name('teknisi_maintenances.index');
    Route::get('/maintenance/add', [MaintenancesController::class, 'add'])->name('teknisi_maintenances.add');
    Route::post('/maintenance/add', [MaintenancesController::class, 'store'])->name('teknisi_maintenances.store');
    Route::get('/maintenance/{id}', [MaintenancesController::class, 'show'])->name('teknis_maintenances.show');
    Route::post('/maintenance/{id}/kerjakan', [MaintenancesController::class, 'kerjakan'])->name('maintenances.kerjakan');
    Route::post('/maintenance/{id}/selesai', [MaintenancesController::class, 'selesai'])->name('maintenances.selesai');
    
    Route::get('/sensor', [SensorController::class, 'index'])->name('teknisi_sensors.index');
    Route::get('/sensor/create', [SensorController::class, 'create'])->name('teknisi_sensors.create');
    Route::post('/sensor/create', [SensorController::class, 'store'])->name('teknisi_sensors.store');
    Route::get('/sensor/{id}', [SensorController::class, 'show'])->name('teknisi_sensors.show');
    Route::get('/sensor/{id}/edit', [SensorController::class, 'edit'])->name('teknisi_sensors.edit');
    // Route::get('/channel/add', [ThingspeakChannelController::class, 'add_channel'])->name('channel.add');
    // Route::post('/channel/add', [ThingspeakChannelController::class, 'store'])->name('channel.store');
    Route::get('/sensor/export', [SensorController::class, 'export']);
    // Route::get('/data-sensor', [ThingspeakChannelController::class, 'index'])->name('teknisi_sensors.index');
    Route::match(['put', 'patch'], '/data-sensor/{id}', [SensorController::class, 'update'])->name('teknisi_sensors.update');
    Route::delete('/data-sensor/{id}', [SensorController::class, 'destroy'])->name('teknisi_sensors.destroy');
});

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/mark-as-read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

Route::get('/emisi-test', [SumberEmisiController::class, 'test'])->name('emisis.test');
require __DIR__.'/auth.php';
