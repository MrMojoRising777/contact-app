<?php

namespace App\Models\Scopes;

trait SimpleSoftDeletes
{
  protected static function bootSimpleSoftDeletes()
    {
        // OPTION 1: CREATE SCOPE CLASS
        static::addGlobalScope(new SimpleSoftDeletingScope);

        // OPTION 2: CREATE SCOPE DIRECTLY IN MODEL
        // static::addGlobalScope('softDeletes', function (Builder $builder) {
        //     $builder->whereNull('deleted_at');
        // });
    }
}