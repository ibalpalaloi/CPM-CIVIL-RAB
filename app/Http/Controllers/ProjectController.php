<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Exports\RecapMaterialAndPriceExport;
use App\Exports\RecapMaterialExport;
use App\Exports\RabExport;

use App\Models\Contractor;
use App\Models\Contractor_on_project;
use App\Models\Job;
use App\Models\D_contractor_on_project;
use App\Models\D_job_on_project;
use App\Models\Job_category;
use App\Models\Job_on_project;
use App\Models\Material;
use App\Models\Material_of_job;
use App\Models\Material_of_job_project;
use App\Models\Project_summary;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;
use DB;

class ProjectController extends Controller
{
    //
    public function project()
    {
        $contractors = Contractor::all();
        $job_category = Job_category::all();
        return view('project.project', ['contractors' => $contractors, 'job_category'=>$job_category]);
    }

    public function post_new_project(Request $request)
    {
        try {
            $id = $this->generate_code_with_time();
            $id = 'PS-' . $id;
            $project = new Project_summary;
            $project->id = $id;
            $project->project_name = $request->project_name;
            $project->building_name = $request->building_name;
            $project->project_owner = $request->project_owner;
            $project->year = $request->year;


            $contractor = Contractor::find($request->contractor_id);

            $contractor_on_project = new D_contractor_on_project;
            $contractor_on_project_id = 'DCOP-' . $this->generate_code_with_time();
            $contractor_on_project->contractor_id = $request->contractor_id;
            $contractor_on_project->project_summary_id = $project->id;
            $contractor_on_project->id = $contractor_on_project_id;

            $contractor_on_project->save();
            $project->save();

            $project = Project_summary::find($project->id);

            return response()->json([
                'project' => $project,
                'contractor' => $contractor,
                'statusCode' => 200
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_table_list_job(Request $request)
    {
        $data_jobs = [];
        $jobs = Job::where('job_name', 'LIKE', '%' . $request->key . '%')
                    ->where('job_category_id', $request->jobcategoryid)
                    ->get();
        // $jobs = $jobs->toArray();
        $i=0;
        foreach($jobs as $job){
            $data_jobs[$i]['job_id'] = $job->id;
            $data_jobs[$i]['job_category'] = $job->job_category->job_category;
            $data_jobs[$i]['job_name'] = $job->job_name;
            $data_jobs[$i]['unit'] = $job->unit;
            $total_price = DB::select(
                "SELECT sum(material_of_job.qty * material.price) as total from material_of_job 
                inner join material 
                on material_of_job.material_id = material.id 
                where material_of_job.job_id = :job_id",
                ['job_id'=>$job->id]
            );
            // dd($total_price[0]->total);
            if(count($total_price)>0){
                $data_jobs[$i]['total_price'] = $total_price[0]->total;

            }else{
                $data_jobs[$i]['total_price'] = 0;
            }
            $i++;
        }
        $view = view('project.include.table_list_job', compact('data_jobs'))->render();

        return response()->json(['table' => $view, 'statusCode' => 200], 200);
    }

    public function get_table_list_project(Request $request)
    {
        $projects = Project_summary::where('project_name', 'LIKE', '%' . $request->key . '%')
            ->orWhere('id_project', 'LIKE', '$' . $request->key)
            ->get();
        $view = view('project.include.table_list_project', compact('projects'))->render();
        return response()->json(['table' => $view, 'statusCode' => 200], 200);
    }

    public function get_project($id)
    {
        try {
            $project = Project_summary::find($id);
            if($project->status == 'posted'){
                $contractor = Contractor_on_project::where('project_summary_id', $project->id)->first();
            }else{
                $contractor = d_contractor_on_project::where('project_summary_id', $project->id)->first();
            }
            return response()->json([
                'project' => $project,
                'contractor' => $contractor,
                'statusCode' => 200
            ], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_table_job_on_project($id)
    {
        try {
            $project_summary = Project_summary::find($id);
            if($project_summary->status == 'posted'){
                return $this->get_table_job_on_project_posted($id);
            }
            $data_job_on_project = [];
            $d_job_on_project = D_job_on_project::where('project_summary_id', $id)->get();
            $i = 0;
            foreach ($d_job_on_project as $data) {
                $data_job_on_project[$i] = $data->toArray();
                $data_job_on_project[$i]['job_name'] = $data->job->job_name;
                $data_job_on_project[$i]['job_category'] = $data->job->job_category->job_category;
                $data_job_on_project[$i]['job_desc'] = $data->job->desc;
                $data_job_on_project[$i]['unit'] = $data->job->unit;
                $data_job_on_project[$i]['desc'] = $data->desc;
                $price = 0;
                $materials_on_job = Material_of_job::where('job_id', $data->job_id)->get();
                foreach ($materials_on_job as $material_on_job) {
                    $price += $data->qty * $material_on_job->qty * $material_on_job->material->price;
                }
                $data_job_on_project[$i]['price'] = $price;
                $data_job_on_project[$i]['status'] = 'unposted';
                $i++;
            }
            // dd($data_job_on_project);
            $view = view('project.include.table_d_job_on_project', compact('data_job_on_project'))->render();
            return response()->json(['table' => $view, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function get_table_job_on_project_posted($id){
        $job_on_project = Job_on_project::where('project_summary_id', $id)->get();
        $data_job_on_project = [];
        // dd($job_on_project);
        $i = 0;
        foreach($job_on_project as $data){
            $data_job_on_project[$i]['id'] = $data->id;
            $data_job_on_project[$i]['job_category'] = $data->job_category;
            $data_job_on_project[$i]['job_name'] = $data->job_name;
            $data_job_on_project[$i]['job_desc'] = $data->desc;
            $data_job_on_project[$i]['qty'] = $data->qty;
            $data_job_on_project[$i]['unit'] = $data->unit;
            $data_job_on_project[$i]['desc'] = $data->desc_job_on_project;
            $materials = Material_of_job_project::where('job_on_project_id', $data->id)->get();
            $price = 0;
            foreach($materials as $material){
                $price = $data->qty * $material->qty * $material->price;
            }
            $data_job_on_project[$i]['price'] = $price;
            $data_job_on_project[$i]['status'] = "posted";
            $i++;
        }
        // dd($data_job_on_project);
        $view = view('project.include.table_d_job_on_project', compact('data_job_on_project'))->render();
        return response()->json(['table' => $view, 'statusCode' => 200], 200);
    }

    public function get_job($id)
    {
        try {
            $job = Job::find($id);
            return response()->json(['job' => $job, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function post_new_job($project_id, $job_id, Request $request)
    {
        try {
            $id = $this->generate_code_with_time();
            $id = 'DJOP-' . $id;
            $job = new D_job_on_project;
            $job->id = $id;
            $job->project_summary_id = $project_id;
            $job->job_id = $job_id;
            $job->qty = $request->qty;
            $job->desc = $request->desc;
            $job->save();

            return response()->json(['job' => $job, 'statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_d_job_on_project($id)
    {
        try {
            $job = D_job_on_project::find($id);
            $job->delete();

            return response()->json(['statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


    public function delete_project_summary($id)
    {
        try {
            $project = Project_summary::find($id);
            $job_on_project = D_job_on_project::where('project_summary_id', $id)->delete();
            $contractor_on_project = D_contractor_on_project::where('project_summary_id', $id)->delete();
            $project->delete();

            return response()->json(['statusCode' => 200], 200);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function export_material_and_price($id){
        $project = Project_summary::find($id);
        // dd($project->id);
        $name = 'RekapMaterialPrice-('.$project->id.').xlsx';
        return Excel::download(new RecapMaterialAndPriceExport($id), $name);
    }

    public function recap_rab($id){
        $project = Project_summary::find($id);
        // dd($project->id);
        $name = 'RekapRAB-('.$project->id.').xlsx';
        return Excel::download(new RabExport($id), $name);
    }

    public function post_update_project(Request $request, $id){
        try{
            Validator::make($request->all(), [
                'project_name' => 'required',
                'building_name' => 'required',
                'project_owner' => 'required',
                'year' => 'required',
                'contractor_id' => 'required',
            ])->validate();

            $project = Project_summary::find($id);
            $project->project_name = $request->project_name;
            $project->building_name = $request->building_name;
            $project->project_owner = $request->project_owner;
            $project->year = $request->year;
            $project->save();

            $d_contractor_on_project = D_contractor_on_project::where('project_summary_id', $id)->first();
            $d_contractor_on_project->contractor_id = $request->contractor_id;
            $d_contractor_on_project->save();

            return response()->json(['statusCode'=>200], 200);
        }
        catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function export_recap_material($project_id){
        $project = Project_summary::find($project_id);
        $name = 'RekapMaterial-('.$project->id.').xlsx';
        return Excel::download(new RecapMaterialExport($project_id), $name);

    }

    

    public function post_project($id){
        $project = Project_summary::find($id);
        $d_contractor_on_project = D_contractor_on_project::where('project_summary_id', $id)->get();
        foreach($d_contractor_on_project as $data){
            $db_id = $this->generate_code_with_time();
            $db_id = 'COP-' . $db_id;
            $contractor_on_project = new Contractor_on_project;
            $contractor_on_project->id = $db_id;
            $contractor_on_project->project_summary_id = $id;
            $contractor_on_project->contractor_id = $data->contractor_id;
            $contractor_on_project->contractor_name = $data->contractor->contractor_name;
            $contractor_on_project->contact = $data->contractor->contact;
            $contractor_on_project->desc = $data->contractor->desc;
            $contractor_on_project->save();
        }

        $d_job_on_project = D_job_on_project::where('project_summary_id', $id)->get();
        $y = 1;
        foreach($d_job_on_project as $data){
            $db_id = $this->generate_code_with_time();
            $db_id = 'JOP-' . $db_id.$y;
            $job_on_project = new Job_on_project;
            $job_on_project->id = $db_id;
            $job_on_project->project_summary_id = $id;
            $job_on_project->job_id = $data->job_id;
            $job_on_project->job_name = $data->job->job_name;
            $job_on_project->desc = $data->job->desc;
            $job_on_project->qty = $data->qty;
            $job_on_project->unit = $data->job->unit;
            $job_on_project->desc_job_on_project = $data->desc;
            $job_on_project->job_category = $data->job->job_category->job_category;
            $job_on_project->Save();
            $job_on_project = Job_on_project::find($db_id);
            $y++;

            $i = 1;
            foreach($data->job->material_of_job as $material_of_job){
                $db_id = $this->generate_code_with_time();
                $db_id = 'MOJP-' . $db_id .$y.$i;
                $material_of_job_project = new Material_of_job_project;
                $material_of_job_project->id = $db_id;
                $material_of_job_project->project_summary_id = $id;
                $material_of_job_project->job_on_project_id = $job_on_project->id;
                $material_of_job_project->material_category_id = $material_of_job->material->material_category_id;
                $material_of_job_project->material_category_name = $material_of_job->material->material_category->material_category;
                $material_of_job_project->sub_material_category_id = $material_of_job->material->sub_material_category_id;
                $material_of_job_project->sub_material_category_name = $material_of_job->material->sub_material_category->sub_material;
                $material_of_job_project->material_id = $material_of_job->material->id;
                $material_of_job_project->material_name = $material_of_job->material->id;
                $material_of_job_project->qty = $material_of_job->qty;
                $material_of_job_project->unit =  $material_of_job->material->unit;
                $material_of_job_project->price = $material_of_job->material->price;
                $material_of_job_project->area = $material_of_job->material->area;
                $material_of_job_project->desc = $material_of_job->material->desc;
                $material_of_job_project->save();
                $i++;
            }
        }
        $d_contractor_on_project = D_contractor_on_project::where('project_summary_id', $id)->delete();
        $d_job_on_project = D_job_on_project::where('project_summary_id', $id)->delete();

        $project->status = 'posted';
        $project->save();

        return response()->json(['statusCode'=>200],200);
    }
};
