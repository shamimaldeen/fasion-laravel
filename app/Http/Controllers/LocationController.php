<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\District;
use App\Models\Division;
use Illuminate\Http\Request;

class LocationController extends Controller
{
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
}
