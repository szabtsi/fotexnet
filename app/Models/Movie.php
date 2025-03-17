<?php

namespace App\Models;

use App\Observers\MovieObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(MovieObserver::class)]
class Movie extends Model
{
    /** @use HasFactory<\Database\Factories\MovieFactory> */
    use HasFactory;

    protected $guarded = [];
}
