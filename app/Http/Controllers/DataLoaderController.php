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
use DB;

class DataLoaderController extends Controller
{

   public function __construct()
    {

    }

    public function load()
    {
        $item_no = 0;
        $upc_code = 1;
        $inventory_import = 2;
        $item_description = 3;
        $department_number = 4;
        $manufacturer_id = 5;
        $rsr_regular_price = 6;
        $inventory_quantity = 7;
        $product_weight = 8;
        $model = 9;
        $full_manufacturer_name = 10;
        $status = 11;
        $expanded_product_description = 12;

        $rec = 1;
        $local_file = 'rst_inventory.txt';
        $server_file = '/ftpdownloads/rsrinventory.txt';

        $filecontent = Storage::disk('ftp-rsr')->get($server_file);

//        var_dump($filecontent);

        Storage::disk('download')->put($local_file, $filecontent);



//        Storage::disk('download')->put($local_file, $filecontent);

        echo 'done';

        /*
                    $file = fopen($local_file,"r");
                    while(!feof($file))
                    {
                        if($rec>1)
                        {
                            $data = fgetcsv($file,0,';');
                            var_dump($data);
                        }
                        $rec++;
                    }
                    fclose($file);
        */
    }

}
