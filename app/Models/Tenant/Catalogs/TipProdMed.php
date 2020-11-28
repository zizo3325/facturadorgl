<?php
//achonto
namespace App\Models\Tenant\Catalogs;
use Illuminate\Database\Eloquent\Builder;
use Hyn\Tenancy\Traits\UsesTenantConnection;

class TipProdMed extends ModelCatalog
{
    use UsesTenantConnection;

    protected $table = "cat_tipprodmed";
    public $incrementing = false;

}