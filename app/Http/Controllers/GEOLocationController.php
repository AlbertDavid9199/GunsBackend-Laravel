<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\BedRequest;
use Carbon\Carbon;
use App\Helpers\Helper;
use App\Models\Inventory_Import;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\GEOLocation;
use DB;

class GEOLocationController extends Controller
{

   public function __construct()
    {

    }
    
    public function byCity($city)
    {
        return GEOLocation::where('city','=',trim(strtolower($city)))->get()->toJson();
    }
    
    public function byState($state)
    {
        return GEOLocation::where('state','=',trim(strtolower($state)))->get()->toJson();
    }

    public function byZip($zip)
    {
        return GEOLocation::where('zip','=',$zip)->get()->toJson();
    }

    public function byAreaCode($area_code)
    {
        return GEOLocation::where('area_code','=',$area_code)->get()->toJson();

    }

    public function byCounty($county)
    {
        return GEOLocation::where('county_name','=',trim(strtolower($county)))->get()->toJson();

    }

    public function byLanLong($lat, $lon)
    {
        return GEOLocation::where('latitude','=',$lat)->where('longitude','=',$lon)->get()->toJson();

    }

    public function nearZip($zip, $rad)
    {
        $result = array();
        $geos = GEOLocation::where('zip','=',$zip)->get();
        foreach($geos as $geo)
        {
            array_push($result,$this->near($geo->latitude, $geo->longitude, $rad));
        }
        return $result;
    }

    public function nearAreacode($areacode, $rad)
    {
        $result = array();
        $geos = GEOLocation::where('area_code','=',$areacode)->get();
        foreach($geos as $geo)
        {
            array_push($result,$this->near($geo->latitude, $geo->longitude, $rad));
        }
        return $result;

    }

    public function near($lat, $lon, $rad)
    {

        $earth = 3959;  // earth's mean radius, km
        $sql = "SELECT
                  g.*, (
                    ".$earth." * acos (
                      cos ( radians(".$lat.") )
                      * cos( radians( latitude ) )
                      * cos( radians( longitude ) - radians(".$lon.") )
                      + sin ( radians(".$lat.") )
                      * sin( radians( latitude ) )
                    )
                  ) AS distance
                FROM geo_location g
                HAVING distance < ".$rad."
                ORDER BY distance;";
        return DB::select(DB::raw($sql));
    }


}
