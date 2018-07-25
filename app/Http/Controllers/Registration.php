<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Auth;
use App\Http\Requests;
use App\Register;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\URL;

class Registration extends Controller
{

    // public function __construct(){
    //     $this->middleware('auth');
    // }


     function index(Request $request){

            return view('pages.login');
    }


     function register_form(){
    	return view('pages.register');
    }

    /**
     * Customer Validation Username and Passsword if correct 
     * 
     */

     function customerDetails(Request $request){

        $contents = [];
        $contents['email_address'] = $request->input('email_address');
        $contents['password'] = $request->input('psw');

        //Login Validation
        $query = Register::where('email_address',$contents['email_address'])
                ->where('password',$contents['password'])->first();
        
        if (count($query) > 0) {
            
            $contents['id'] = $query->id;

            $result = Register::where('id',$contents['id'])->first();
               
            return view('pages.customer_details',compact('contents','result'));
            
        }else{

            $error_message = "Invalid Email or Password";
            return view('pages.login',compact('error_message'));
            
        }
        

    }

     function do_logout(Request $request){
        $request->session()->forget('session_start');
        Auth::logout();
        return redirect('login');
    }

     function getSession(Request $request){

        return $request->session()->get('session_start');
    }

    /**
     * Inserting of data in database
     * @param  Firstname,lastname,address,email address,phone number,password
     * @return Json [Jquery ajax]
     */
     function process_registration(Request $request){
        //$data =  $request->all();
        $imageFile = $request->file('userImage');
        $imageName = $imageFile->getClientOriginalName();
        $imageType = $imageFile->getMimeType();
        $imageRealPath = $imageFile->getRealPath();
        $firstname = $request->input('fname');
        $lastname = $request->input('lname');
        $address = $request->input('address');
        $email_address = $request->input('email');
        $password = $request->input('password');
        $phone_number = $request->input('pnumber');


        /******/ 
        $destinationPath = "public/images/";
        $basePath = $imageFile->move($destinationPath,$imageName);

        //**
        //Passing view in JSON
        //$view['body'] = View('welcome',compact('contents','result'))->render();
        
       // $result = DB::table('registers')->insert($data);
        $current_time =  date("Y-m-d H:i:s"); 
        $data = array(
                'firstname' => $firstname,
                'lastname'=>$lastname,
                'address'=>$address,
                'email_address'=>$email_address,
                'password'=>$password,
                'phone_number'=>$phone_number,
                'ImageType'=>$imageType,
                'ImageName'=>$imageName,
                'created_at' => $current_time,
                'updated_at' => $current_time
            );

        $result['content']['results'] = Register::insert($data);

        return response()->json($result);
        //return $result->toSql();
    }


    function update_customer_details(Request $request){
        
        $current_time =  date("Y-m-d H:i:s");
        $file = $request->file('img_file');
        if (!isset($file)) {


            $field_name =  $request->input('customer_field');
            $customer_id =  $request->input('id');
            $field_name_value =  $request->input('customer_field_value');

            $update_result = DB::update("UPDATE `registers` SET `".$field_name."` = '".$field_name_value."' , `updated_at` = '".$current_time."' WHERE `id` = ".$customer_id);

            if ($update_result > 0) {
                    
                    $data['contents']['new_value'] = $field_name_value;
                    $data['contents']['affected_rows'] = $update_result;
             }else{

                return false;
             }
        
        }else{

            // /***************Image Data*****************************
            $customer_id = $request->input('customer_id');
            
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getMimeType();
            $data = array(

                'ImageName' => $fileName,
                'ImageType' => $fileType,
                'updated_at' => $current_time,

            );

            $destinationPath = "/public/images/";
            $file->move($destinationPath,$fileName);
            //$fullpath = base_path().$destinationPath.$fileName;
            $fullpath = URL::to('/');

            $update_result = Register::where('id',$customer_id)->update($data);
            $data = [];
            if ($update_result > 0) {
                    //$data['contents'] = $update_result;
                    
                    $data['contents']['results'] = $update_result;
                    $data['contents']['fullpath'] = $fullpath."/public/images/".$fileName;
            }else{

                return false;
            }
        }



        return response()->json($data);
    }
}
