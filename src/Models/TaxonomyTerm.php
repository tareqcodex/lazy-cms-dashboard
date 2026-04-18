<?php

namespace Acme\CmsDashboard\Models;

use Illuminate\Database\Eloquent\Model;

class TaxonomyTerm extends Model
{
    protected $table = 'taxonomy_terms';
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(TaxonomyTerm::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(TaxonomyTerm::class, 'parent_id');
    }
}
