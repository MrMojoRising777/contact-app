<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // protected $table = "app_companies";
    // protected $primaryKey = "_id";
    // protected $guarded = [];  // this only allows existing columns to be changed in mass assignment
    protected $fillable = ['name', 'email', 'address', 'website'];  // specify what columns can be changed in mass assignment

    // when mass assigning, if a non-existing column is updated
    //  $fillable will run and update the existing columns
    //  $guarded throws an exception
}
