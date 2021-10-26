<?php

namespace App\Http\Controllers;

use App\Models\Ban;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;

class BanController extends Controller
{
	/**
	 * @OA\Get(
	 * 		path="/bans",
	 * 		summary="Get a list of bans from the database, based on given parameters",
	 * 		description="Returns an object containing a list of bans, along with metadata about the response.",
	 * 		tags={"Bans"},
	 * 		operationId="getBans",
	 * 		@OA\Parameter(
	 * 			description="Key of banned player to search for",
	 * 			in="query",
	 * 			name="ckey",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="string"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Key of the banning admin to search for",
	 * 			in="query",
	 * 			name="a_ckey",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="string"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Select bans after the given ID (inclusive)",
	 * 			in="query",
	 * 			name="after",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Select bans before the given ID (inclusive)",
	 * 			in="query",
	 * 			name="before",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Maximum number of bans per page",
	 * 			in="query",
	 * 			name="limit",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Selects which page to retrieve",
	 * 			in="query",
	 * 			name="page",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Parameter(
	 * 			description="Whether bans should be retrieved in reverse order (oldest->newest)",
	 * 			in="query",
	 * 			name="reverse",
	 * 			required=false,
	 * 			@OA\Schema(
	 * 				type="boolean"
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response=200,
	 * 			description="List of registered servers",
	 * 			@OA\JsonContent(
	 * 				@OA\Property(
	 * 					property="total_rows",
	 * 					description="Total number of bans that matched given criteria",
	 * 					type="number",
	 * 					format="int32"
	 * 				),
	 * 				@OA\Property(
	 * 					property="rows",
	 * 					description="Number of bans in the current page",
	 * 					type="number",
	 * 					format="int32"
	 * 				),
	 * 				@OA\Property(
	 * 					property="pages",
	 * 					description="Number of pages available for selection",
	 * 					type="number",
	 * 					format="int32"
	 * 				),
	 * 				@OA\Property(
	 * 					property="bans",
	 * 					description="Array of ban objects retrieved",
	 * 					type="array",
	 * 					@OA\Items(ref="#/components/schemas/ban")
	 * 				)
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response=500,
	 * 			description="Server error",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		)
	 * )
	 */
	public function bans(Request $request) {
		$queryArgs = $request->query();
		$page = 1;
		$limit = env('BAN_PAGE_LIMIT');
		$queryItems = [];
		$reverse = false;
		// Handle all the URL params
		foreach ($queryArgs as $key => $value) {
			switch($key) {
				case 'ckey':
				case 'a_ckey':
					$queryItems[] = [$key, '=', $value];
					break;
				case 'after':
					if(intval($value) > 0) $queryItems[] = ['id', '>=', intval($value)];
					break;
				case 'before':
					if(intval($value) > 0) $queryItems[] = ['id', '<=', intval($value)];
					break;
				case 'page':
					if(intval($value) > 0) $page = intval($value);
					break;
				case 'limit':
					if(intval($value) > 0) $limit = min(intval($value), env('BAN_PAGE_LIMIT'));
					break;
				case 'reverse':
					// Cheeky little check because I like the flag format (?reverse), but a lot of people like the boolean format (?reverse=true)
					if($value != 'false') $reverse = true;
					break;
			}
		}
		// Filter ban types depending on environment config
		if(!env('BAN_JOBBANS')) {
			$queryItems[] = ['role', '=', 'Server'];
		}
		if(env('BAN_PERMA_ONLY')) {
			$queryItems[] = ['expiration_time', '=', null];
		}
		$query = Ban::where($queryItems);
		$totalRows = $query->count();
		$result = $query->limit($limit)->offset($limit * ($page - 1))->orderBy('id', $reverse ? 'asc' : 'desc')->get();
		$rows = $result->count();
		$response = [
						'total_rows' => $totalRows,
						'rows' => $rows,
						'pages' => max(ceil($totalRows/$limit), 1),
						'bans' => $result->toArray()
					];
		return response()->json($response);
	}
}
