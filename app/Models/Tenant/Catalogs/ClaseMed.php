<?php
//achonto
namespace App\Models\Tenant\Catalogs;
use Illuminate\Database\Eloquent\Builder;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class ClaseMed extends ModelCatalog
{
    use UsesTenantConnection;

    protected $table = "cat_clasemed";
    public $incrementing = false;

}