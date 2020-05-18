<?php

namespace App\Http\Controllers\RoleToUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\RoleToUser\RoleToUser;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class RoleToUserController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){

        $roleToUsers = RoleToUser::get();
        $responseData = $this->helping->indexData(['roleToUsers'=> $roleToUsers]);
        return response()->json($responseData);

    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $infoExist = RoleToUser::find($request->id);
        
        if(! $infoExist){
            $isExixt = RoleToUser::where('role_id', $request->role_id)->where('user_id', $request->user_id)->first();

            if(! $isExixt){
                $validator = Validator::make($request->all(), [
                    'role_id' => 'required|numeric',
                    'user_id' => 'required|numeric',
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
    
                $contactInfoId = RoleToUser::create([
                    'role_id' => $request->role_id,
                    'user_id' => $request->user_id,
                ]);
            }else{
                $responseData = $this->helping->existData();
                return response()->json($responseData);
            }
        }else{
            $validator = Validator::make($request->all(), [
                'role_id' => 'required|numeric',
                'user_id' => 'required|numeric',
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
            $contactInfoId = RoleToUser::where('id', $request->id)->update([
                'role_id' => $request->role_id,
                'user_id' => $request->user_id,
            ]);
        }
        if($contactInfoId){
            $urlToRoles = RoleToUser::get();
            $responseData = $this->helping->savingData(['roleToUsers'=> $urlToRoles]);
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
            $deleteData = RoleToUser::where('id', $id)->delete();
            
            if(! $deleteData){
                return response()->json($this->helping->noContent());
            }

            $datas = RoleToUser::get();
            return response()->json($this->helping->deletingData($datas));
        }

        $datas = RoleToUser::get();
        return response()->json($this->helping->invalidDeleteId($datas));
    }
}
