<?php

use App\Http\Controllers\SearchNewsController;
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

/**
 * @apiName            searchNews
 *
 * @api                {GET} /v1/search/Classes search Classes and articles
 * @apiDescription     Endpoint description here...
 *
 * @apiVersion         1.0.0
 * @apiPermission      Authenticated ['permissions' => '', 'roles' => '']
 *
 * @apiHeader          {String} accept=application/json
 * @apiHeader          {String} authorization=Bearer
 *
 * @apiParam           {String} parameters here...
 *
 * @apiSuccessExample  {json} Success-Response:
 * HTTP/1.1 200 OK
 *
 * [
 * {
 * "headline": "Trump-era Chinese spy balloons went undetected",
 * "category": "general",
 * "pub_date": "2023-02-07T16:43:17Z",
 * "web_url": "https://www.bbc.co.uk/Classes/world-us-canada-64547394",
 * "author": "https://www.facebook.com/bbcnews",
 * "source": "BBC News"
 * }
 * ]
 */
Route::get('/news/search', [SearchNewsController::class, 'searchNews']);
