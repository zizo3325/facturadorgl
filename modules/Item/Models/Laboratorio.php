<?php

namespace Modules\Item\Models;

use App\Models\Tenant\Item;
use App\Models\Tenant\ModelTenant;

class Laboratorio extends ModelTenant
{

    protected $fillable = [ 
        'name',
    ];
 
    public function items()
    {
        return $this->hasMany(Item::class);
    }
 

}