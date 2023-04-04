<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConferenceController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\UserController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/conferences', [ConferenceController::class, 'store']);
    Route::get('/conferences/{conference}', [ConferenceController::class, 'show']);
    Route::get('/conferences/{conference}/edit', [ConferenceController::class, 'edit']);
    Route::put('/conferences/{conference}', [ConferenceController::class, 'update']);
    Route::delete('/conferences/{conference}', [ConferenceController::class, 'delete']);
    Route::post('/conferences/{conference}/join', [ConferenceController::class, 'join']);
    Route::post('/conferences/{conference}/unjoin', [ConferenceController::class, 'unjoin']);

    Route::get('/twitter_config', [ConferenceController::class, 'twitter']);

    Route::get('/lectures', [LectureController::class, 'index']);
    Route::post('/lectures/{conferenceId}', [LectureController::class, 'store']);
    Route::get('/lectures/{conferenceId}/show', [LectureController::class, 'showWithConference']);
    Route::get('/lectures/{lecture}', [LectureController::class, 'show']);
    Route::get('/lectures/{lecture}/edit', [LectureController::class, 'edit']);
    Route::put('/lectures/{lecture}', [LectureController::class, 'update']);
    Route::delete('/lectures/{lecture}', [LectureController::class, 'delete']);
    Route::get('lectures/{lecture}/downloadPresentation', [LectureController::class, 'downloadPresentation']);
    Route::post('/lectures/{lecture}/favorite', [LectureController::class, 'favorite']);
    Route::post('/lectures/{lecture}/unfavorite', [LectureController::class, 'unfavorite']);
    Route::get('/lectures/{user}/favorites', [LectureController::class, 'favorites']);

    Route::post('/comments', [CommentController::class, 'store']);
    Route::get('/comments/{lectureId}', [CommentController::class, 'show']);
    Route::put('/comments/{comment}', [CommentController::class, 'update']);

    Route::get('/users/{user}', [UserController::class, 'edit']);
    Route::put('/users/{user}', [UserController::class, 'update']);

    Route::get('/categories', [CategoryController::class, 'index']);
    Route::get('/categories/edit', [CategoryController::class, 'edit']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::delete('/categories/{category}', [CategoryController::class, 'delete']);
});

Route::get('/conferences', [ConferenceController::class, 'index']);
