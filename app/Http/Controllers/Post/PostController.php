<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Model\Post\Post;
use Validator, Auth;
use App\Http\Controllers\Helper\HelperController;

class PostController extends Controller
{
    private $helping = "";

    public function __construct(){
        $this->helping = new HelperController();
    }

    public function index(){

        $posts = Post::get();
        $responseData = $this->helping->indexData(['posts'=> $posts]);
        return response()->json($responseData);

    }

    public function store(Request $request){
        $userId = Auth::user()->id;
        $infoExist = Post::find($request->id);
        
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

            $contactInfoId = Post::create([
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
            $contactInfoId = Post::where('id', $request->id)->update([
                'title' => $request->title
            ]);
        }

        if($contactInfoId){
            $posts = Post::get();
            $responseData = $this->helping->savingData(['posts'=> $posts]);
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
            $deleteData = Post::where('id', $id)->delete();
            
            if(! $deleteData){
                return response()->json($this->helping->noContent());
            }

            $datas = Post::get();
            return response()->json($this->helping->deletingData($datas));
        }

        $datas = Post::get();
        return response()->json($this->helping->invalidDeleteId($datas));
    }
}
