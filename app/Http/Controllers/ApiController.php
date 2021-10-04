<?php

namespace App\Http\Controllers;

class ApiController extends Controller
{
	/**
	* @OA\Get(
	* 		path="/version",
	* 		summary="Get current API version",
	* 		description="Returns an object with the current API version",
	* 		tags={"API"},
	* 		operationId="getApiVersion",
	* 		@OA\Response(
	* 			response=200,
	* 			description="Current API Version",
	* 			@OA\JsonContent(ref="#/components/schemas/version")
	* 		),
	* 		@OA\Response(
	* 			response=500,
	* 			description="Server error",
	* 			@OA\JsonContent(ref="#/components/schemas/error")
	* 		)
	* )
	*/
	public function version() {
		return response()->json(['version' => env('APP_VERSION')]);
	}
}
