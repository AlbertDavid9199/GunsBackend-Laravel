<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GEOLocation extends Model {


    public $timestamps = false;

    protected $table = 'geo_location';
    protected $primaryKey = 'geo_location_id';

    protected $fillable = [ 'city','state','zip','area_code','county_fips','county_name','timezone','dst','latitude','longitude','zip_type'];

    protected $guarded = [];

}
