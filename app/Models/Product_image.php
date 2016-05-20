<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product_image extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_images';
    protected $primaryKey = 'product_image_id';

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
    protected $fillable = ['product_id', 'name', 'location'];
}
