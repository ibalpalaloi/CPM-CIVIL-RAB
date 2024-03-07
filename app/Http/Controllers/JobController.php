<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Job_category;
use App\Models\Job;
use App\Models\Material;
use App\Models\Material_category;
use App\Models\Material_of_job;
use Exception;

class JobController extends Controller
{
    //
    public function job_category()
    {
        $job_category = Job_category::all();
        return view('admin.Job_category', ['job_category' => $job_category]);
    }

    public function post_new_job_category(Request $request)
    {
        try {
            $id = $this->generate_code_with_time();
            $id = 'JC-' . $id;

            $job_category = new Job_category;
            $job_category->id = $id;
            $job_category->job_category = $request->job_category;
            $job_category->save();

            return response()->json(['job_category' => $job_category, 'statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_job_category($id)
    {
        try {
            Job_category::where('id', $id)->delete();

            return response()->json(['statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function job()
    {
        $job_category = Job_category::all();
        $jobs = Job::all();
        $materialCategories = Material_category::all();
        return view('admin.job_input', [
            'jobs' => $jobs,
            'job_category' => $job_category,
            'materialCategories' => $materialCategories
        ]);
    }

    public function post_new_job(Request $request)
    {
        try {
            $id = $this->generate_code_with_time();
            $id = 'J-' . $id;
            $job = new Job;
            $job->id = $id;
            $job->job_category_id = $request->job_category;
            $job->job_name = $request->job_name;
            $job->desc = $request->desc;
            $job->unit = $request->unit;
            $job->save();

            $data_job = $job->toArray();
            $job_category = Job_category::where('id', $job->job_category_id)->first();
            $data_job['job_category'] = $job_category->category;

            return response()->json(['job' => $data_job, 'statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    function getTableSearchJob(Request $req)
    {
        try {
            
            $jobs = Job::where('job_name', 'LIKE', '%' . $req->input . '%')
                    ->where('job_category_id', $req->job_category_id)
                    ->get();
            $view = view('admin.include.table_search_job', compact('jobs'))->render();
            return response()->json(['view' => $view, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getJob($id)
    {
        try {
            $job = Job::find($id);
            $dataJob = $job->toArray();
            $dataJob['jobCategory'] = $job->job_category->job_category;
            return response()->json(['job' => $dataJob, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getMaterialOfJob($id)
    {
        try {
            $dataMaterials = [];
            $i = 0;
            $materialCategories = Material_category::all();
            foreach ($materialCategories as $materialCategory) {
                $itemOfJob = DB::select(
                    "SELECT material_of_job.id, material_of_job.job_id, material_of_job.material_id, material_of_job.qty, material.material_name, material.unit, material.price, material_category.material_category
                        FROM material_of_job
                        JOIN material
                            ON material_of_job.material_id = material.id
                        JOIN material_category
                            ON material_category.id = material.material_category_id
                        WHERE material_category.material_category = :materialCategory AND
                        material_of_job.job_id = :id",
                    ['materialCategory' => $materialCategory->material_category, 'id' => $id]
                );
                $dataMaterials[$i]['materialCategory'] = $materialCategory->material_category;
                $dataMaterials[$i]['listMaterial'] = $itemOfJob;
                $i++;
            }

            $view = view('admin.include.table_item_of_job', compact('dataMaterials'))->render();
            return response()->json(['view' => $view, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function get_total_price($id){
        try{
            $dataMaterials = [];
            $i = 0;
            $materialCategories = Material_category::all();
            foreach ($materialCategories as $materialCategory) {
                $itemOfJob = DB::select(
                    "SELECT material_of_job.id, material_of_job.job_id, material_of_job.material_id, material_of_job.qty, material.material_name, material.unit, material.price, material_category.material_category
                        FROM material_of_job
                        JOIN material
                            ON material_of_job.material_id = material.id
                        JOIN material_category
                            ON material_category.id = material.material_category_id
                        WHERE material_category.material_category = :materialCategory AND
                        material_of_job.job_id = :id",
                    ['materialCategory' => $materialCategory->material_category, 'id' => $id]
                );
                $dataMaterials[$i]['materialCategory'] = $materialCategory->material_category;
                $dataMaterials[$i]['listMaterial'] = $itemOfJob;
                $i++;
            }

            $total_price = 0;
            foreach($dataMaterials as $data){
                foreach($data['listMaterial'] as $list){
                    $total_price += $list->qty * $list->price;
                }
            }

            return response()->json(['total_price'=>$total_price, 'statusCode'=>200], 200);
        }catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getMaterialOfMaterialCategory($id)
    {
        try {
            // dd($id);
            $materials = Material::where('material_category_id', $id)->get();
            return response()->json(['materials' => $materials, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function post_new_item_of_job(Request $request)
    {
        try {
            $this->validate($request, [
                'job_id' => 'required',
                'material_id' => 'required',
                'quantity' => 'required|regex:/^(([0-9]*)(\.([0-9]+))?)$/'
            ]);

            $id = $this->generate_code_with_time();
            $id = 'MOJ-' . $id;

            $item_of_job = new Material_of_job;
            $item_of_job->id = $id;
            $item_of_job->job_id = $request->job_id;
            $item_of_job->material_id = $request->material_id;
            $item_of_job->qty = $request->quantity;
            $item_of_job->save();

            return response()->json(['item_of_job' => $item_of_job, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function deleteItemOfJob($id)
    {
        try {
            $itemOfJob = Material_of_job::find($id);
            $itemOfJob->delete();
            return response()->json(['statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_job($id)
    {
        try {
            $job = Job::find($id);
            $Material_of_job = Material_of_job::where('job_id', $id)->delete();
            $job->delete();

            return response()->json(['statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function update_job(Request $request, $id)
    {
        try {
            $job = Job::find($id);
            $job->job_category_id = $request->job_category;
            $job->job_name = $request->job_name;
            $job->unit = $request->unit;
            $job->desc = $request->desc;
            $job->save();

            return response()->json(['statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_material_of_job($id)
    {
        try {
            $material = Material_of_job::find($id);
            $data_material = $material->toArray();
            $data_material['job_name'] = $material->job->job_name;
            $data_material['material'] = $material->material->material_name;
            $data_material['material_category'] = $material->material->material_category->material_category;

            return response()->json(['material' => $data_material, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function post_edit_material_of_job(Request $request, $id)
    {
        try {
            $request->validate([
                'index' => 'required|numeric'
            ]);

            $material_of_job = Material_of_job::find($id);
            $material_of_job->qty = $request->index;
            $material_of_job->save();

            return response()->json(['material' => $material_of_job, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
