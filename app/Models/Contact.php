<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Scopes\AllowedFilterSearch;
use App\Models\Scopes\AllowedSort;

class Contact extends Model
{
    // use SimpleSoftDeletes here
    use HasFactory, SoftDeletes, AllowedFilterSearch, AllowedSort;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }
}
