<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Material;
use App\Models\D_job_on_project;
use App\Models\Job_on_project;
use App\Models\Material_of_job;
use App\Models\Material_of_job_project;
use App\Models\Project_summary;

class RecapMaterialExportPosted implements FromView
{
    protected $id;

    function __construct($id) {
        $this->id = $id;
    }
    
    public function view(): View
    {
        //
        $job_on_project = Job_on_project::where('project_summary_id', $this->id)->get();
        $list_materials = [];
        $j = 1;

        foreach($job_on_project as $data){
            $material_of_job_project = Material_of_job_project::where('job_on_project_id', $data->id)->get();
            foreach($material_of_job_project as $material_of_job){
                if(count($list_materials) > 0){
                    $push = true;
                    for($i = 0; count($list_materials) > $i; $i++){
                        if($list_materials[$i]['material_id'] == $material_of_job->material_id){
                            $list_materials[$i]['qty'] = $list_materials[$i]['qty'] + ($data->qty * $material_of_job->qty);
                            $push = false;
                        }

                        if($push == true){
                            $list = array(
                                "material_id" => $material_of_job->material_id,
                                "unit" => $material_of_job->unit,
                                "material_name" => $material_of_job->material_name,
                                "qty" => $data->qty * $material_of_job->qty,
                            );
                            array_push($list_materials, $list);
                        }
                    }
                }
                else{
                    $list = array(
                        "material_id" => $material_of_job->material_id,
                        "unit" => $material_of_job->unit,
                        "material_name" => $material_of_job->material_name,
                        "qty" => $data->qty * $material_of_job->qty,
                    );

                    array_push($list_materials, $list);
                }
            }
        }
        dd($list_materials);
        $project = Project_summary::find($this->id);
        return view('exports.recap_material', compact('list_materials', 'project'));
    }
}
