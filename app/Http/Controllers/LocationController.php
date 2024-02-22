<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Category;
use App\Models\Country;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class LocationController extends Controller
{


//Route::get('/test',[LocationController::class,'getCountry']);

    public function getCountry(){
        $url = 'https://restcountries.com/v3.1/all';
        $response  = Http::get($url);
        $response  = json_decode($response->body(),true);
//        foreach ($response as $val){
//            $data['name'] = $val['name']['common'];
//           Country::create($data);
//        }

       // dd(count($response));


    }


    public function getDivisions()
    {
        $divisions =  Division::select('id','name')->get();
        return $divisions;
    }

    public function getDistricts(int $division_id)
    {
        $districts =  District::where('division_id',$division_id)->select('id','name')->get();
        return $districts;
    }

    public function getAreas(int $district_id)
    {
        $areas =  Area::where('district_id',$district_id)->select('id','name')->get();
        return $areas;
    }

    public function getDistrictData()
    {
        $districts =  District::select('id','name')->get();
        return $districts;
    }

}
