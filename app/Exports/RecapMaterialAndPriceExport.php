<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\D_job_on_project;
use App\Models\Material_category;
use App\Models\Project_summary;
use DB;

class RecapMaterialAndPriceExport implements FromView
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
        $d_job_on_project = D_job_on_project::where('project_summary_id', $this->id)->get();
        $data_job_on_project = [];
        $material_categories = Material_category::all();
        $i = 0;
        foreach($d_job_on_project as $data){
            $data_job_on_project[$i]['job_category'] = $data->job->job_category->job_category;
            $data_job_on_project[$i]['job'] = $data->job->job_name;
            $data_job_on_project[$i]['qty'] = $data->qty;
            $data_job_on_project[$i]['desc'] = $data->job->desc;
            $data_job_on_project[$i]['unit'] = $data->job->unit;
            $j = 0;
            foreach($material_categories as $material_category){
                $data_job_on_project[$i]['material'][$j]['material_category'] = $material_category->material_category;
                $itemOfJob = DB::select(
                    "SELECT material_of_job.id, material_of_job.job_id, material_of_job.material_id, material_of_job.qty, material.material_name, material.unit, material.price, material_category.material_category
                        FROM material_of_job
                        JOIN material
                            ON material_of_job.material_id = material.id
                        JOIN material_category
                            ON material_category.id = material.material_category_id
                        WHERE material_category.material_category = :materialCategory AND
                        material_of_job.job_id = :id",
                    ['materialCategory' => $material_category->material_category, 'id' => $data->job_id]

                );
                $data_job_on_project[$i]['material'][$j]['list'] = $itemOfJob;
                $j++;
            }
            $i++;
        }
        return view('exports.recap_material_and_price', ['data_job_on_project'=>$data_job_on_project]);
    }
}
