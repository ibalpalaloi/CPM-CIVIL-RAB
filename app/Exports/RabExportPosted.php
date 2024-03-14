<?php

namespace App\Exports;

use App\Models\Job_on_project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Project_summary;
use App\Models\Material_category;
use DB;
use SebastianBergmann\CodeCoverage\Report\Xml\Project;

class RabExportPosted implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $id;
    function __construct($id) {
        $this->id = $id;
    }

    public function view(): view
    {
        //
        $project_summary = Project_summary::find($this->id);
        $job_on_project = Job_on_project::where('project_summary_id', $this->id)->get();
        $data_job_on_project = [];
        $material_categories = Material_category::all();
        $i = 0;
        foreach($job_on_project as $data){
            $data_job_on_project[$i]['job_category'] = $data->job_category;
            $data_job_on_project[$i]['job'] = $data->job_name;
            $data_job_on_project[$i]['qty'] = $data->qty;
            $data_job_on_project[$i]['desc_job'] = $data->desc;
            $data_job_on_project[$i]['unit'] = $data->unit;
            $data_job_on_project[$i]['desc_job_project'] = $data->desc_job_on_project;

            foreach($material_categories as $material_category){
                $itemOfJob = DB::select(
                    "SELECT material_of_job_project.id, material_of_job_project.job_on_project_id, material_of_job_project.material_id, material_of_job_project.qty, material_of_job_project.material_name, material_of_job_project.unit, material_of_job_project.price, material_of_job_project.material_category_name
                    from material_of_job_project
                    where material_of_job_project.material_category_id = :MaterialCategoryID AND
                    material_of_job_project.job_on_project_id = :job_on_project_id AND
                    material_of_job_project.project_summary_id = :projectSummaryID",
                    ['MaterialCategoryID' => $material_category->id, 'job_on_project_id' => $data->id, 'projectSummaryID'=>$this->id]
                );
                
                $price = 0;
                foreach($itemOfJob as $itemofjob){
                    $price += $itemofjob->price * $data->qty;
                }

                $data_job_on_project[$i][$material_category->material_category] = $price;
            }
            $i++;
        }
        // dd($data_job_on_project);
        return view('exports.recap_rab', ['data_job_on_project'=>$data_job_on_project, 'project_summary'=>$project_summary]);
    }
}
