<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Scopes\SimpleSoftDeletingScope;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'address', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function tasks()
    {
        return $this->hasMany(Tasks::class);
    }

    protected static function booted()
    {
        // OPTION 1: CREATE SCOPE CLASS
        static::addGlobalScope(new SimpleSoftDeletingScope);

        // OPTION 2: CREATE SCOPE DIRECTLY IN MODEL
        // static::addGlobalScope('softDeletes', function (Builder $builder) {
        //     $builder->whereNull('deleted_at');
        // });
    }
}
