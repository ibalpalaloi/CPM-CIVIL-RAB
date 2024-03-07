<?php

namespace App\Http\Controllers;

use App\Models\D_job_on_project;
use Exception;
use DB;
use Illuminate\Http\Request;
use App\Models\material_category;
use App\Models\Sub_material_category;
use App\Models\Material;
use App\Models\Material_of_job;

class MaterialController extends Controller
{
    //
    public function material_category(){
        $categories = Material_category::all();
        return view('admin.material_category', ['categories'=>$categories]);
    }

    public function post_new_material_category(Request $request){
        $check = Material_category::where('material_category', $request->material_category)->get();

        if(count($check) > 0){
            $message = "category is already exist";
            return response()->json(['message'=>$message, 'statusCode'=>400]);
        }

        $id = $this->generate_code_with_time();
        $id = 'C-'.$id;
        $material_category = Material_category::create([
            'id' => $id,
            'material_category' => $request->material_category,
        ]);

        return response()->json(['material_category'=>$material_category, 'statusCode'=>200], 200);
    }

    public function sub_material_category(){
        $sub_categories = Sub_material_category::all();
        // dd($sub_categories[0]->material_category);
        $categories = Material_category::all();
        return view('admin.sub_material_category', ['sub_categories'=>$sub_categories, 'categories'=>$categories]);
    }

    public function post_new_sub_material_category(Request $request){

        $id = $this->generate_code_with_time();
        $id = 'SC-'.$id;
        $category = new Sub_material_category;
        $category->id = $id;
        $category->sub_material = $request->sub_material_category;
        $category->save();

        $category = Sub_material_category::find($category->id);
        $data_category = $category->toArray();

        return response()->json(['category'=>$category, 'statusCode'=>200], 200);
    }

    public function delete_sub_material_category($id){
        try{
            $material = Material::where('sub_material_category_id', $id)->get();
            if(count($material) > 0){
                Sub_material_category::where('id', $id)->delete();
                return response()->json(['statusCode'=>200], 200);
            }
            return "any material with this category";
        }catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function material(){
        $material_category = Material_category::orderBy('material_category', 'desc')->get();
        $sub_material_category = Sub_material_category::orderBy('sub_material', 'desc')->get();
        $materials = Material::all();

        return view('admin.material', ['material_category'=>$material_category, 'materials'=>$materials, 'sub_material_category'=>$sub_material_category]);
    }

    public function post_new_material(Request $request){
        try {
            $id = $this->generate_code_with_time();
            $id = 'M-'.$id;

            $material = new Material;
            $material->id = $id;
            $material->material_category_id = $request->material_category_id;
            $material->sub_material_category_id = $request->sub_material_category_id;
            $material->material_name = $request->material;
            $material->unit = $request->unit;
            $material->price = $request->price;
            $material->area = $request->area;
            $material->desc = $request->description;
            $material->save();

            $data_material = $material->toArray();
            $material_category = Material_category::where('id', $material->material_category_id)->first();
            $data_material['category'] = $material_category->material_category;
            $sub_material_category = Sub_material_category::where('id', $material->sub_material_category_id)->first();
            $data_material['sub_category'] = $sub_material_category->sub_material;

            return response()->json(['material'=>$data_material, 'statusCode'=>200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_material($id){
        try{
            $check = DB::select(
                "SELECT d_job_on_project.id as d_job_on_project_id, d_job_on_project.qty, job.id as job_id, job.job_name, material_of_job.material_id 
                FROM d_job_on_project 
                INNER JOIN job on d_job_on_project.job_id = job.id 
                INNER JOIN material_of_job on material_of_job.job_id = job.id
                WHERE material_of_job.material_id = :id_material",
                ['id_material'=>$id]
            ); 
            if(count($check) > 0){
                return "material cannot delete, cause any project job project with this material";
            }
            
            $check = Material_of_job::where('material_id', $id)->first();
            if(!empty($check)){
                $string = strval($check->job->job_name);
                return $string." check this job";
            }
            Material::where('id', $id)->delete();
            
            return response()->json(['statusCode'=>200], 200);
        }catch (\Exception $e) {
            return $e->getMessage();
        }
        
    }

    public function get_material($id){
        try{
            $material = Material::where('id', $id)->first();
            $data_material = $material->toArray();
            $data_material['material_category'] = Material_category::where('id', $material['material_category_id'])->first();
            $data_material['sub_material_category'] = sub_material_category::where('id', $material['sub_material_category_id'])->first();

            return response()->json(['material'=>$data_material, 'statusCode'=>200], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function post_edit_material(Request $request, $id){
        try{
            $material = Material::find($id);
            $material->material_category_id = $request->material_category_id;
            $material->sub_material_category_id = $request->sub_material_category_id;
            $material->material_name = $request->material;
            $material->unit = $request->unit;
            $material->price = $request->price;
            $material->area = $request->area;
            $material->desc = $request->description;
            $material->save();

            $material = Material::find($id);
            $data_material = $material->toArray();
            $data_material['category'] = $material->material_category->material_category;
            $data_material['sub_material_category'] = $material->sub_material_category->sub_material;

            return response()->json(['material'=>$material, 'statusCode'=>200], 200);
        }
        catch (\Exception $e) {
            return $e->getMessage();
        }
        

    }

    public function post_edit_material_category($id, Request $request){
        $sub_material_category = Sub_material_category::find($id);
        $sub_material_category->sub_material = $request->category;
        $sub_material_category->save();

        return response()->json(['category'=>$sub_material_category, 'statusCode'=>200], 200);
    }
}
