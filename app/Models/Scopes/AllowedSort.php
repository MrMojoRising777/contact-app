<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AllowedSort
{
  public function parseSortDirection()
  {
    return strpos(request()->query('sort_by'), "-") === 0 ? 'desc' : 'asc' ;
  }

  public function parseSortColumn()
  {
    return ltrim(request()->query('sort_by'), "-");
  }

  public function scopeAllowedSorts(Builder $query, array $columns, $defaultColumn = null)
  {
    $column = $this->parseSortColumn();
    if (in_array($column, $columns)) {
      return $query->orderBy($column, $this->parseSortDirection());
    }
    return $query;
  }
}