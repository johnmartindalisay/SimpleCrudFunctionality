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
use File;
use Illuminate\Support\Facades\Storage;

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
        //$destinationPath = "public/images/";
        //$basePath = $imageFile->move($destinationPath,$imageName);


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

        $result = Register::insert($data);

        if ($result) {
            
            $user = Register::where('email_address',$data['email_address'])->first();

            $path = public_path().'/images/'.$user->id;
            File::makeDirectory($path);

            $imageFile->move($path,$imageName);

            $contents['content']['results'] = true;
        }

        return response()->json($contents);
    }


    function update_user_image(Request $request){
    
        $data = [];
        $contents = [];
        $current_time =  date("Y-m-d H:i:s");
        $file = $request->file('img_file');
        $fileName = $file->getClientOriginalName();
        $customer_id =  $request->input('customer_id');
        $fileType = $file->getMimeType();
        $field_name =  $request->input('customer_field');
        $field_name_value =  $request->input('customer_field_value');

        //fullpath of the user image - get the ImageName  of the existing user
        $user = Register::where('id',$customer_id)->first();
        $path = public_path().'/images/'.$customer_id."/".$user->ImageName;

        //Delete the existing Image file 
        
        File::delete($path);
        //then Update the database with the new existing Image FIle uploaded and move the file
        $data = array(

                'ImageName' => $fileName,
                'ImageType' => $fileType,
                'updated_at' => $current_time,

        );

        $update_result = Register::where('id',$customer_id)->update($data);
        
        $newPath = public_path().'/images/'.$customer_id;
        $file->move($newPath,$fileName);
        $new_user = Register::where('id',$customer_id)->first();

        //$data['content']['path'] = $path;
        //
        $fullpathImage = "public/images/".$new_user->id."/".$new_user->ImageName;
        $contents['contents']['existing_fileImage'] = $fullpathImage;
        $contents['contents']['results'] = $update_result;

        return response()->json($contents);
    }


    function update_user_details(Request $request){

           // $contents = $request->all();
            $current_time =  date("Y-m-d H:i:s");
            $field_name =  $request->input('customer_field');
            $customer_id =  $request->input('id');
            $field_name_value =  $request->input('customer_field_value');


            $update_result = DB::update("UPDATE `registers` SET `".$field_name."` = '".$field_name_value."' , `updated_at` = '".$current_time."' WHERE `id` = ".$customer_id);

            if ($update_result > 0) {
                    
                    $data['contents']['new_value'] = $field_name_value;
                    $data['contents']['affected_rows'] = $update_result;
             }

            return response()->json($data);

    }
}
