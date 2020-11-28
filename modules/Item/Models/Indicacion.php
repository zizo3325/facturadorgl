<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class Indicacion extends ModelTenant
{
    public $table = "indicaciones";
    protected $fillable = [ 
        'id',
        'active',
        'name',
    ];
 
    public function items()
    {
        return $this->hasMany(Item::class);
    }
 

}