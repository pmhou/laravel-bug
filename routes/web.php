<?php

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

    $countries = [
        'UK' => \App\Country::firstOrCreate(['name' => 'UK']),
        'US' => \App\Country::firstOrCreate(['name' => 'US']),
    ];

    $users = [
        'Bob' => \App\User::firstOrCreate([
            'name' => 'Bob',
            'email' => 'bob@example.com',
            'country_id' => $countries['US']->id,
        ], ['password' => bcrypt('password')]),
        'John' => \App\User::firstOrCreate([
            'name' => 'John',
            'email' => 'john@example.com',
            'country_id' => $countries['UK']->id,
        ], ['password' => bcrypt('password')]),
    ];

    \App\Post::firstOrCreate([
        'user_id' => $users['John']->id,
        'title' => 'Foo',
    ]);

    \App\Post::firstOrCreate([
        'user_id' => $users['Bob']->id,
        'title' => 'Bar',
    ]);

    $uk = \App\Country::where('name', 'UK')->first();

    echo "Delete all posts belonging to the UK using 'each()'...";

    $uk->posts()->each(function ($post) {
        echo "\nDeleting post ID: $post->id";
        echo "\nPost belongs to " . \App\Post::find($post->id)->user->country->name;
    });

    echo "\n\nDelete all posts belonging to the UK using dynamic 'posts' property...";

    foreach ($uk->posts as $post) {
        echo "\nDeleting post ID: $post->id";
        echo "\nPost belongs to " . \App\Post::find($post->id)->user->country->name;
    }
});
