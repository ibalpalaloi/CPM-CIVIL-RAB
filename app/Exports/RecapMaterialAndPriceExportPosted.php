<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\D_job_on_project;
use App\Models\Job_on_project;
use App\Models\Material_category;
use App\Models\Project_summary;
use DB;

class RecapMaterialAndPriceExportPosted implements FromView
{
    /**
    // * @return \Illuminate\Support\Collection
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
            $data_job_on_project[$i]['desc'] = $data->desc;
            $data_job_on_project[$i]['unit'] = $data->unit;
            $j= 0;
            foreach($material_categories as $material_category){
                $data_job_on_project[$i]['material'][$j]['material_category'] = $material_category->material_category;
                $itemOfJob = DB::select(
                    "SELECT material_of_job_project.id, material_of_job_project.job_on_project_id, material_of_job_project.material_id, material_of_job_project.material_id, material_of_job_project.material_name, material_of_job_project.unit, material_of_job_project.price, material_of_job_project.material_category_name, material_of_job_project.qty
                    FROM material_of_job_project
                    where material_of_job_project.material_category_name = :materialCategoryName AND
                    material_of_job_project.job_on_project_id = :jobProjectID",
                    ['materialCategoryName' => $material_category->material_category, 'jobProjectID' => $data->id]
                );

                $data_job_on_project[$i]['material'][$j]['list'] = $itemOfJob;
                $j++;
            }
            $i++;
        }
        // dd($data_job_on_project);
        return view('exports.recap_material_and_price', ['data_job_on_project'=>$data_job_on_project]);
    }
}
