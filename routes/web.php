<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MachineController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ReportController;

Route::group(['middleware' => ['web']], function(){
    Route::get('/', function () {
        return view('auth.login');
    }); 

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::group(['middleware' => ['web', 'auth']], function(){
    Route::group(['prefix'=>'user','as'=>'user.'], function(){
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/create', [UserController::class, 'store'])->name('create');
        Route::get('/list', [UserController::class, 'list'])->name('list');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete', [UserController::class, 'delete'])->name('delete');
        Route::get('/visit/{id}', [UserController::class, 'visit'])->name('visit');
        Route::put('/updateown/{id}', [UserController::class, 'updateown'])->name('updateown');
    });

    Route::group(['prefix' => 'job', 'as'=>'job.'], function(){
        Route::get('/progress', [JobController::class, 'progressjob'])->name('progress');
        Route::get('/process', [JobController::class, 'processjob'])->name('process');
        Route::get('/start', [JobController::class, 'startjob'])->name('start');
        Route::get('/complete/{id}', [JobController::class, 'completejob'])->name('complete');
        Route::post('/complete', [JobController::class, 'savejob'])->name('complete');
        Route::post('/create', [JobController::class, 'store'])->name('create');
        Route::post('/update', [JobController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'machine', 'as'=>'machine.'], function(){
        Route::get('/create', [MachineController::class, 'create'])->name('create');
        Route::post('/create', [MachineController::class, 'store'])->name('create');
        Route::get('/list', [MachineController::class, 'list'])->name('list');
        Route::get('/edit/{id}', [MachineController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MachineController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'part', 'as'=>'part.'], function(){
        Route::get('/create', [PartController::class, 'create'])->name('create');
        Route::post('/create', [PartController::class, 'store'])->name('create');
        Route::get('/list', [PartController::class, 'list'])->name('list');
        Route::get('/edit/{id}', [PartController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [PartController::class, 'update'])->name('update');
        Route::post('/upload', [PartController::class, 'upload'])->name('upload');
    });

    Route::group(['prefix' => 'report', 'as'=>'report.'], function(){
        Route::get('/employee', [ReportController::class, 'employee'])->name('employee');
        Route::post('/employee', [ReportController::class, 'filteremployee'])->name('employee');
        Route::get('/partnumber', [ReportController::class, 'partnumber'])->name('partnumber');
        Route::post('/partnumber', [ReportController::class, 'filterpartnumber'])->name('partnumber');
        Route::get('/timesheet', [ReportController::class, 'timesheet'])->name('timesheet');
        Route::post('/timesheet', [ReportController::class, 'filtertimesheet'])->name('timesheet');
    });
});