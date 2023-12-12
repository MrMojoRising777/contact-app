<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\SimpleSoftDeletingScope;
use Illuminate\Database\Eloquent\Builder;

class Contact extends Model
{
    // use SimpleSoftDeletes here
    use HasFactory, SoftDeletes;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    public function scopeSortByNameAlpha(Builder $query)
    {
        return $query->orderBy('first_name');
    }

    public function scopeFilterByCompany(Builder $query)
    {
        if ($companyId = request()->query("company_id")) {
            $query->where("company_id", $companyId);
        }
        return $query;
    }
}
