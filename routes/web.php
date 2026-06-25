<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PetaPbbController;

/*
|--------------------------------------------------------------------------
| LANDING
|--------------------------------------------------------------------------
*/

Route::view('/', 'home')->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::view('/home', 'home')->name('home');
Route::view('/tentang', 'tentang')->name('tentang');
Route::view('/struktur', 'struktur')->name('struktur');

/*
|--------------------------------------------------------------------------
| KATALOG HUB
|--------------------------------------------------------------------------
*/

Route::view('/katalog', 'katalog')->name('katalog.index');

/*
|--------------------------------------------------------------------------
| GIS DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/katalog/pbb-p2', [PetaPbbController::class, 'index'])
    ->middleware('auth')
    ->name('katalog.pbbp2');

Route::get('/katalog/dashboard-pbb', [PetaPbbController::class, 'dashboard'])
    ->middleware('auth')
    ->name('katalog.dashboard');

Route::view('/katalog/bphtb', 'katalog.bphtb')->name('katalog.bphtb');
Route::view('/katalog/reklame', 'katalog.reklame')->name('katalog.reklame');

/*
|--------------------------------------------------------------------------
| GIS API - MAPLIBRE GEOJSON (FIX FINAL)
|--------------------------------------------------------------------------
*/

Route::get('/api/pbb-p2', function () {

    $rows = DB::table('data_tanah')
        ->selectRaw('gid, status_pem, ST_AsGeoJSON(geom) as geom')
        ->whereNotNull('geom')
        ->limit(500)
        ->get();

    $features = $rows->map(function ($row) {

        return [
            "type" => "Feature",
            "properties" => [
                "gid" => $row->gid,
                "status_pem" => $row->status_pem,
            ],
            "geometry" => json_decode($row->geom)
        ];

    });

    return response()->json([
        "type" => "FeatureCollection",
        "features" => $features
    ]);

});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';