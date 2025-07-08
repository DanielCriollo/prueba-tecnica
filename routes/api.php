<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CourseTopicController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API v1 Routes
Route::prefix('v1')->group(function () {
    // Course Topics API Routes
    Route::prefix('course-topics')->group(function () {
        // Basic CRUD operations
        Route::get('/', [CourseTopicController::class, 'index']);
        Route::post('/', [CourseTopicController::class, 'store']);
        Route::get('/all', [CourseTopicController::class, 'all']);
        Route::get('/{id}', [CourseTopicController::class, 'show']);
        Route::put('/{id}', [CourseTopicController::class, 'update']);
        Route::delete('/{id}', [CourseTopicController::class, 'destroy']);
    });
});
