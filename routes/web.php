<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('q1', function () {
    $employees = collect([
        [
            'name' => 'John',
            'email' => 'john3@example.com',
            'sales' => [
                ['customer' => 'The Blue Rabbit Company', 'order_total' => 7444],
                ['customer' => 'Black Melon', 'order_total' => 1445],
                ['customer' => 'Foggy Toaster', 'order_total' => 700],
            ],
        ],
        [
            'name' => 'Jane',
            'email' => 'jane8@example.com',
            'email' => 'jane8@example.com1',
            'sales' => [
                ['customer' => 'The Grey Apple Company', 'order_total' => 203],
                ['customer' => 'Yellow Cake', 'order_total' => 8730],
                ['customer' => 'The Piping Bull Company', 'order_total' => 3337],
                ['customer' => 'The Cloudy Dog Company', 'order_total' => 5310],
            ],
        ],
        [
            'name' => 'Dave',
            'email' => 'dave1@example.com',
            'sales' => [
                ['customer' => 'The Acute Toaster Company', 'order_total' => 1091],
                ['customer' => 'Green Mobile', 'order_total' => 2370],
            ],
        ],
    ]);
    
    return  $employees->sortByDesc(function ($employee) {
        return max(array_column($employee['sales'], 'order_total'));
    })->values()->first();

});
Route::get('q2p1', [CustomerController::class, 'customerWithHighestSpending']);
Route::get('q2p2', [CustomerController::class, 'customerWithHighestOrders']);

Route::get('q3', function () {
    $scores = collect ([
        ['score' => 76, 'team' => 'A'],
        ['score' => 62, 'team' => 'B'],
        ['score' => 82, 'team' => 'C'],
        ['score' => 86, 'team' => 'D'],
        ['score' => 91, 'team' => 'E'],
        ['score' => 67, 'team' => 'F'],
        ['score' => 67, 'team' => 'G'],
        ['score' => 82, 'team' => 'H'],
    ]);

    $scoresUnique =  $scores->sortByDesc('score')->values()->unique('score'); //only unique to skip duplicate scores
    $ranked = $scoresUnique->map(function ($item, $key) {
        return array_merge($item,['rank'=>$key+1]);
    });

    $scores->each(function ($item,$key)use($ranked){    //reinsert the duplicated value with this same rank
        if(!$ranked->contains('team',$item['team'])){
            $duplicatedItem = $ranked->firstWhere('score',$item['score']);
            $ranked->push(['score' => $item['score'], 'team' => $item['team'], 'rank' => $duplicatedItem['rank']]);
        }
    });

    return $ranked;
});

