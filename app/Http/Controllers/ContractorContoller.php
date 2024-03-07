<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use App\Models\D_contractor_on_project;
use Illuminate\Http\Request;

class ContractorContoller extends Controller
{
    //

    public function index()
    {
        return view('admin.contractor.index');
    }

    public function post_new_contractor(Request $request)
    {
        try {
            $request->validate([
                'contractor_name' => 'required',
                'contact' => 'required'
            ]);

            $contractor = Contractor::where('contractor_name', $request->contractor_name)->first();
            if (!empty($contractor)) {
                return "Name alredy exists";
            }

            $id = $this->generate_code_with_time();
            $id = 'C-' . $id;
            $contractor = new Contractor;
            $contractor->id  = $id;
            $contractor->contractor_name = $request->contractor_name;
            $contractor->contact = $request->contact;
            $contractor->desc = $request->desc;
            $contractor->save();

            return response()->json(['contractor' => $contractor, 'statusCode' => 200]);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getTableSearchContractor(Request $request)
    {
        try {
            $contractors = Contractor::where('contractor_name', 'LIKE', '%' . $request->key . '%')->get();
            $view = view('admin.contractor.include.table_search_contractor', compact('contractors'))->render();
            return response()->json(['table' => $view, 'statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function getContractor($id)
    {
        try {
            $contractor = Contractor::find($id);
            return response()->json(['contractor' => $contractor, 'statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function post_update_contractor($id, Request $request)
    {
        try {
            $request->validate([
                'contractor_name' => 'required'
            ]);

            $contractor = Contractor::find($id);
            $contractor->contractor_name = $request->contractor_name;
            $contractor->contact = $request->contact;
            $contractor->desc = $request->desc;
            $contractor->save();

            return response()->json(['contractor' => $contractor, 'statusCode' => 200], 200);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete_contractor($id){
        $check_contractor = D_contractor_on_project::where('contractor_id', $id)->get();
        if(count($check_contractor) > 0){
            return "contractor can't delete because use on project";
        }

        Contractor::where('id', $id)->delete();

        return response()->json(['statusCode'=>200], 200);
        
    }
}
