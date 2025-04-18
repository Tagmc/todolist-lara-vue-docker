<?php

use App\Http\Controllers\Api\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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



// Get Todos	GET	/api/v1/todos
// Create Todo	POST	/api/v1/todos
// Update Todo	PUT	/api/v1/todos/{id}
// Delete Todo	DELETE	/api/v1/todos/{id}
// Filter by Priority	GET	/api/v1/todos

Route::prefix('v1')->group(function () {
    Route::apiResource('todos', TodoController::class);
});
