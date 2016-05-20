<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory_Import extends Model {


    public $timestamps = true;

    protected $table = 'inventory_import';
    protected $primaryKey = 'inventory_import_id';

    protected $fillable = [ 'item_no', 'item_description','suggested_dealer','suggested_retail', 'normal_price','sale_price','sales_end','quantity','upc_code', 'manufacturer','gun_type','model_series','caliber','action','capacity','finish','stock','sights','barel_length','overall_length','features'];

    protected $guarded = [];

}
