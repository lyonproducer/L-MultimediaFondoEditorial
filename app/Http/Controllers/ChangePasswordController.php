<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use DB;
use App\User;

class ChangePasswordController extends Controller
{
    public function process(ChangePasswordRequest $request){
    	//return response()->json($request);
    	return $this->getPasswordResetTableRow($request)->count()>0 ? $this->changePassword($request) : 
		$this->tokenNotFoundResponse();
    }

    private function changePassword($request){
    	$user = User::whereEmail($request->email)->first();
    	$user->update(['password'=>$request->password]);

    	$this->getPasswordResetTableRow($request)->delete();

    	return response()->json([
    		'data'=> 'Password Successfully Changed'
    	], Response::HTTP_CREATED);
    }

    private function tokenNotFoundResponse(){
    	return response()->json([
    		'error'=> 'Token or Email incorrect'
    	], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    private function getPasswordResetTableRow($request){
    	return DB::table('password_resets')->where([
    		'email'=> $request->email,
    		'token'=> $request->resetToken
    	]);
    }
}
