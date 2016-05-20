<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';
    protected $primaryKey = 'product_id';

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
    protected $fillable = ['manufacture_id', 'name', 'description', 'sku', 'serial_number', 'product_model', 'barrel_length', 'capacity', 'firing_casing', 'frame_per_material', 'sights'];
}

