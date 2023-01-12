<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\ImageController;
class CompaniesController extends Controller
{
    public function index(){
        return view('companies.index');
    }
    public function create(){
       

        return view('companies.create');
    }
    public function store(Request $request)
    {
//         $request->validate([
    
//             'name'=>'required|string|max:255',
//             'address'=>'required|string|max:255',
//             'lat'=>'required|string|max:255',
//             'lng'=>'required|string|max:255',
//             'description'=>'required|string|max:255',
//         ]);
// var_dump($request);
// dd('stop');
        $company = new Company();
        $company->name = $request->name;
        $company->address = $request->address;
        $company->latitude = $request->lat;
        $company->longitude = $request->lng;
        $company->description = $request->description;

         //upload image 
         $image_name = '';
         $image_path = '';
         if($request->image != null){
 
             $image = new ImageController();
             $image = $image->imageStore($request);
             $image_name = $image['name'];
             $image_path = $image['path'];
         }

         $company->image_name = $image_name;
         $company->image_path = $image_path;
        $company->save();
        return redirect()->route('company.create');
    }

    public function search(Request $request){
 
        $search_text = $request->search_text;
   
        $Companies = Company::select('*')->where('address', 'LIKE', '%'.$search_text.'%')->get();
   
        // Fetch all records
        $response['data'] = $Companies;
   
        return response()->json($response);
     }
    
}
