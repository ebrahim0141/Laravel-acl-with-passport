<?php

namespace App\Http\Controllers\Role;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Role\Role;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class RoleController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){
       
        $roles = Role::get();
        $responseData = $this->helping->indexData(['roles'=> $roles]);
        return response()->json($responseData);

    }

    public function store(Request $request){

        $userId = Auth::user()->id;
        $infoExist = Role::find($request->id);
        
        if(! $infoExist){
            $validator = Validator::make($request->all(), [
                'title' => 'required|string'
            ]);
            
            if($validator->fails()){
                $errors = $validator->errors();
                $errorMsg = null;
                
                foreach ($errors->all() as $msg) {
                    $errorMsg .= $msg;
                }

                $responseData = $this->helping->validatingErrors($errorMsg);
                return response()->json($responseData);
            }

            $contactInfoId = Role::create([
                'title' => $request->title
            ]);
            
        }else{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string'
            ]);
            
            if($validator->fails()){
                $errors = $validator->errors();
                $errorMsg = null;
                
                foreach ($errors->all() as $msg) {
                    $errorMsg .= $msg;
                }
               
                $responseData = $this->helping->validatingErrors($errorMsg);
                return response()->json($responseData);
            }
            $contactInfoId = Role::where('id', $request->id)->update([
                'title' => $request->title
            ]);
        }

        if($contactInfoId){
            $Roles = Role::get();
            $responseData = $this->helping->savingData(['roles'=> $Roles]);
            return response()->json($responseData);
        }else{
             $responseData = $this->helping->serverError();
            return response()->json($responseData);
        }
    }

    public function delete($id){
        if($id){
            if(! is_numeric($id)){
                return response()->json($this->helping->notNumeric());
            }
   
            // $dbData = Role::find($id);
            $deleteData = Role::where('id', $id)->delete();
            
            if(! $deleteData){
                return response()->json($this->helping->noContent());
            }

            $datas = Role::get();
            return response()->json($this->helping->deletingData($datas));
        }

        $datas = Role::get();
        return response()->json($this->helping->invalidDeleteId($datas));
    }
}
