<?php

use App\Http\Controllers\LearningController;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\Profile;
use App\Models\VWUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
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

Route::get('/', function () {
    $response = [
        'success' => true,
        'message' => "Hello World, Welcome to Hell",
        'data' => [
            'user'=> VWUsers::get(), // one to one 
            'categories' => Category::with('posts')->paginate(10),// many to many
            'posts' => Post::with('category')->get(),// many to many
        ]
    ];
    return response()->json($response, Response::HTTP_OK);
});
Route::apiResource('welcome', LearningController::class);

Route::match(['get', 'post'], '/hello', function () {
    $response = [
        'success' => true,
        'message' => "Hello World, Welcome to Hell",
        "data" => null,
    ];
    // abort(429, 'You do not have permission to access this resource.');
    return response()->json($response, Response::HTTP_OK); 
});
