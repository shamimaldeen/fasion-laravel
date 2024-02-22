<?php
 namespace App\Manager;


 use App\Models\Area;
 use App\Models\District;
 use App\Models\Division;
 use Illuminate\Support\Facades\Http;
 use Intervention\Image\Facades\Image;

 class uploadManager{

//     public static function uploadImage(string $imageName,string $path,string $file)
//     {
//         $file->move(public_path($path),$imageName);
//         return $imageName;
//     }


     public function getCountry(){

     }






     // Location Data Save

// Route::get('/test',[CategoryController::class,'setData']);

//     public function setData(){
//         $div_url = 'https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD&page=addressEdit';
//         $response = Http::get($div_url);
//         $divisions = json_decode($response->body(),true);
//
//         foreach ($divisions['module'] as $key=> $division) {
//             if ($key == 8) {
//                 $division_data['name'] = $division['name'];
//                 $division_data['original_id'] = $division['id'];
//                 $division_info = Division::create($division_data);
//
//                 $dis_url = 'https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD&addressId=R3921322&page=addressEdit';
//                 $response = Http::get($dis_url);
//                 $districts = json_decode($response->body(), true);
//                 foreach ($districts['module'] as $key => $district) {
//                     $district_data['name'] = $district['name'];
//                     $district_data['original_id'] = $district['id'];
//                     $district_data['division_id'] = $division_info->id;
//                     $district_info = District::create($district_data);
//
//
//                     $area_url = 'https://member.daraz.com.bd/locationtree/api/getSubAddressList?countryCode=BD&addressId=R80300579&page=addressEdit';
//                     $response = Http::get($area_url);
//                     $areas = json_decode($response->body(), true);
//                     foreach ($areas['module'] as $key => $area) {
//                         $area_data['name'] = $area['name'];
//                         $area_data['original_id'] = $area['id'];
//                         $area_data['district_id'] = $district_info->id;
//                         Area::create($area_data);
//                     }
//                 }
//             }
//
//         }
//         dd('ok 8');
//     }


 }

