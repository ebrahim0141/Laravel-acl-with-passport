<?php

namespace App\Http\Controllers\UrlToRole;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\UrlToRole\UrlToRole;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class UrlToRoleController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){

        $urlToRoles = UrlToRole::get();
        $responseData = $this->helping->indexData(['urlToRoles'=> $urlToRoles]);
        return response()->json($responseData);

    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $infoExist = UrlToRole::find($request->id);
        
        if(! $infoExist){
            $isExixt = UrlToRole::where('url_id', $request->url_id)->where('role_id', $request->role_id)->first();

            if(! $isExixt){
                $validator = Validator::make($request->all(), [
                    'url_id' => 'required|numeric',
                    'role_id' => 'required|numeric',
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
    
                $contactInfoId = UrlToRole::create([
                    'url_id' => $request->url_id,
                    'role_id' => $request->role_id,
                ]);
            }else{
                $responseData = $this->helping->existData();
                return response()->json($responseData);
            }
            
        }else{
            $validator = Validator::make($request->all(), [
                'url_id' => 'required|numeric',
                'role_id' => 'required|numeric',
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
            $contactInfoId = UrlToRole::where('id', $request->id)->update([
                'url_id' => $request->url_id,
                'role_id' => $request->role_id,
            ]);
        }

        if($contactInfoId){
            $urlToRoles = UrlToRole::get();
            $responseData = $this->helping->savingData(['urlToRoles'=> $urlToRoles]);
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
   
            $deleteData = UrlToRole::where('id', $id)->delete();
            
            if(! $deleteData){
                return response()->json($this->helping->noContent());
            }

            $datas = UrlToRole::get();
            return response()->json($this->helping->deletingData($datas));
        }

        $datas = UrlToRole::get();
        return response()->json($this->helping->invalidDeleteId($datas));
    }
}
