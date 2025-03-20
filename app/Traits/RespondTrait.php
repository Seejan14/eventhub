<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait RespondTrait{

    public function successResponse($data=null, $message = null, $code = 200)
	{
		return response()->json([
			'status'=> 'Success', 
			'message' => $message, 
			'data' => $data
		], $code);
	}

	public function errorResponse($data=null,$message = null, $code = 500)
	{
		return response()->json([
			'status'=>'Error',
			'message' => $message,
			'data' => $data
		], $code);
	}
}