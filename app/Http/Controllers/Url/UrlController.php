<?php

namespace App\Http\Controllers\Url;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Url\Url;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class UrlController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){
        // $name = trim('Mohammad Ziaur Rahman Shishir', "  ");
        // $ns = preg_replace('/\s+/', ' ', trim('Mohammad Ziaur Rahman Shishir', "  "));
        
        // return response()->json($ns);
        $urls = Url::get();
        $responseData = $this->helping->indexData(['urls'=> $urls]);
        return response()->json($responseData);

    }

    public function store(Request $request){
        
        $userId = Auth::user()->id;
        $infoExist = Url::find($request->id);
        
        if(! $infoExist){
            $isExist = Url::where('url', $request->url)->where('action_type', $request->action_type)->first();

            if(! $isExist){
                $validator = Validator::make($request->all(), [
                    'title' => 'required|string',
                    'url' => 'required|string',
                    'operation' => 'required|string',
                    'action_type' => 'required|string'
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
    
                $contactInfoId = Url::create([
                    'title' => $request->title,
                    'url' => $request->url,
                    'operation' => $request->operation,
                    'action_type' => $request->action_type
                ]);
            }else{
                $responseData = $this->helping->existData();
                return response()->json($responseData);
            }
        }else{
            $validator = Validator::make($request->all(), [
                'title' => 'required|string',
                'url' => 'required|string',
                'operation' => 'required|string',
                'action_type' => 'required|string'
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
            $contactInfoId = Url::where('id', $request->id)->update([
                'title' => $request->title,
                'url' => $request->url,
                'operation' => $request->operation,
                'action_type' => $request->action_type,
            ]);
        }

        if($contactInfoId){
            $urls = Url::get();
            $responseData = $this->helping->savingData(['urls'=> $urls]);
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
   
            $dbData = Url::find($id);
    
            if(! $dbData){
                return response()->json($this->helping->noContent());
            }

            $deleteData = Url::where('id', $id)->delete();
            $datas = Url::get();
            return response()->json($this->helping->deletingData($datas));
        }

        $datas = Url::get();
        return response()->json($this->helping->invalidDeleteId($datas));
    }
}
