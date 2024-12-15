<?php

use App\Models\Category;
use App\Models\User;
use App\Models\Post;
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
            'user'=> User::with(['cover_image', 'profile'])->get(), // one to one 
            'categories' => Category::with('posts')->paginate(10),// many to many
            'posts' => Post::with('category')->get(),// many to many
        ]
    ];
    return response()->json($response, Response::HTTP_OK);
});
