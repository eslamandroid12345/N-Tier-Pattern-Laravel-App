<?php

use App\Http\Controllers\Api\Auth\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('verify', [AuthController::class, 'verify'])->name('verify');
Route::middleware(['auth:sanctum'])->group(function () {
    /*
    |--------------------------------------------------------------------------
    | AUTH
    |--------------------------------------------------------------------------
    */
    Route::post('logout', [AuthController::class, 'logout']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
 $getReportWithRd0 = $this->reportRepository->getWithCondition(data: [
                            'stage_id' => StagesType::RD0->value,
                            'missing_data' => '0',
                            'synced' => 1,
                            'project_id' => $report->project_id,
                        ], isFirst: true);
 */
