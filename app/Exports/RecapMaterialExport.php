<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Material;
use App\Models\D_job_on_project;
use App\Models\Material_of_job;
use App\Models\Project_summary;

class RecapMaterialExport implements FromView
{

    protected $id;

    function __construct($id) {
        $this->id = $id;
    }
    

    public function view(): View
    {
        $d_job_on_project =  D_job_on_project::where('project_summary_id', $this->id)->get();
        // dd($d_job_on_project);
        $list_materials = [];
        $j = 1;
        foreach($d_job_on_project as $data){
            $material_on_job = Material_of_job::where('job_id', $data->job_id)->get();
            foreach($material_on_job as $material_on_job_){
                $material = Material::where('id', $material_on_job_->material_id)->first();
                if(!empty($material)){
                    if(count($list_materials) > 0){
                        $push = true;
                        for($i = 0; count($list_materials) > $i; $i++){
                            if($list_materials[$i]['material_id'] == $material->id){
                                $list_materials[$i]['qty'] = $list_materials[$i]['qty'] + ($data->qty * $material_on_job_->qty);
                                $push = false;
                            }
                        }
                        if($push == true){
                            $list = array(
                                "material_id" => $material->id,
                                "unit" => $material->unit,
                                "material_name" => $material->material_name,
                                "qty" => $data->qty * $material_on_job_->qty,
                            );
        
                            array_push($list_materials, $list);
                        }
                    }else{
                        $list = array(
                            "material_id" => $material->id,
                            "unit" => $material->unit,
                            "material_name" => $material->material_name,
                            "qty" => $data->qty * $material_on_job_->qty,
                        );
    
                        array_push($list_materials, $list);
                    }
                }
                
                
            }
        }
        $project = Project_summary::find($this->id);
        return view('exports.recap_material', compact('list_materials', 'project'));
    }
}
