<?php

use Illuminate\Support\Facades\Route;

/*
1. Add New task
2. Show All Task
3. Delete task
4. Edit task
5. Filter
*/

Route::get('/', function () {
    $tasks = App\Models\Taskshi::all();
    return view('welcome',compact('tasks'));
});

if(auth()->check())
{
    $task = App\Models\Task::where('owner_id',Auth::user()->id)->get();
}
else{
    $task = null;
}

// My Route goes here
Route::post('/store',[App\Http\Controllers\TaskshiController::class,'store'])->name('store');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/delete/{id}', [App\Http\Controllers\TaskshiController::class, 'delete'])->name('delete');
Route::get('/edit/{id}', [App\Http\Controllers\TaskshiController::class, 'edit'])->name('edit');
Route::post('/update/{id}', [App\Http\Controllers\TaskshiController::class, 'update'])->name('update');
Route::get('/search', [App\Http\Controllers\TaskshiController::class, 'search'])->name('search');
Route::get('/done/{id}',[App\Http\Controllers\TaskshiController::class, 'done'])->name('done');


