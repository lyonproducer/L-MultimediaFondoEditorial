<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Mail;
use DB;
use Carbon\Carbon;

class ResetPasswordController extends Controller
{
    public function sendEmail(Request $request){
    	//valida si el email es correcto
    	if(!$this->validateEmail($request->email)){
    		return $this->failedResponse();
    	}

    	$this->send($request->email);
    	return $this->successResponse();
    }

    public function send($email){
    	//crea un token ramdon
    	$token = $this->createToken($email);
    	//envia el email
    	Mail::to($email)->send(new ResetPasswordMail($token));
    }

    public function createToken($email){
		//verifica si existe un token anteriormente pa que no cree uno nuevo
    	$oldToken = DB::table('password_resets')->where('email',$email)->first();

    	if($oldToken){
    		return $oldToken->token;
    	}
    	//crea un string aleatorio de 60 caracteres
    	$token = str_random(60);
    	$this->saveToken($token,$email);
    	return $token;
    }

    public function saveToken($token,$email){
    	DB::table('password_resets')->insert([
    		'email' => $email,
    		'token' => $token,
    		'created_at' => Carbon::now()
    	]);
    }

    public function validateEmail($email){
    	//valida que el email enviado para resetear exista en la tabla user
    	return !!User::where('email',$email)->first();
    }

    public function failedResponse(){
    	//retorna mensaje de error
    	return response()->json([
    		'error'=> 'Email does\'t not exist on our database'
    	], Response::HTTP_NOT_FOUND);
    }

    public function successResponse(){
    	//retorna mensaje de enviado correctamente
    	return response()->json([
    		'data'=> 'Email have been send succestuflly'
    	], Response::HTTP_OK);
    }
}
