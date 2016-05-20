<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vault extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vaults';
    protected $primaryKey = 'vault_id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'quentity', 'sku', 'serial_number', 'product_model', 'barrel_length', 'capacity', 'firing_casing', 'frame_per_material', 'sights', 'user_id', 'product_id', 'stock_number', 'original_stock_number', 'published', 'published_at', 'price', 'original_price', 'date', 'brand', 'deliber'];
}
