<?php

namespace App\Http\Controllers;

class TopicController extends Controller
{
	/**
	 * Array of BYOND servers that can be accessed
	 *
	 * @var array
	 */
	public $servers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
		$json = file_get_contents(__DIR__ . "/../../../servers.json");
		$this->servers = json_decode($json, true);
    }

	/**
	 * @OA\Get(
	 * 		path="/server/{id}/status",
	 * 		summary="Get the status of a server",
	 * 		description="Returns a detailed description of the current status of a server, depending on the server ID given.",
	 * 		tags={"Server"},
	 * 		operationId="getStatus",
	 * 		@OA\Parameter(
	 * 			description="ID of server to fetch status for",
	 * 			in="path",
	 * 			name="id",
	 * 			required=true,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response=200,
	 * 			description="Status data for the target server",
	 * 			@OA\JsonContent(ref="#/components/schemas/status")
	 * 		),
	 * 		@OA\Response(
	 * 			response=404,
	 * 			description="Server ID doesn't exist",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		),
	 * 		@OA\Response(
	 * 			response=500,
	 * 			description="Server error",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		)
	 * )
	 */
	public function status($id) {
		$response = $this->topic_wrapper($id, 'status');
		if(is_array($response)) {
			if($response['statuscode'] == 200) {
				// Parse some numeric values into booleans, because byond moment
				$data = $response['data'];
				$data['respawn'] = (bool) $data['respawn'];
				$data['enter'] = (bool) $data['enter'];
				$data['vote'] = (bool) $data['vote'];
				$data['ai'] = (bool) $data['ai'];
				$data['hub'] = (bool) $data['hub'];
				return response()->json($data);
			} else {
				abort($response['statuscode'], $response['response']);
			}
		} else {
			abort(500, "Topic communication error");
		}
	}

	/**
	 * @OA\Get(
	 * 		path="/server/{id}/players",
	 * 		summary="Get a list of players currently on the server",
	 * 		description="Returns a list of ckeys currently logged into the server.",
	 * 		tags={"Server"},
	 * 		operationId="getPlayers",
	 * 		@OA\Parameter(
	 * 			description="ID of server to fetch player list from",
	 * 			in="path",
	 * 			name="id",
	 * 			required=true,
	 * 			@OA\Schema(
	 * 				type="integer",
	 * 				format="int32"
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response=200,
	 * 			description="Player list from the target server",
	 * 			@OA\JsonContent(type="array", @OA\Items(type="string"))
	 * 		),
	 * 		@OA\Response(
	 * 			response=404,
	 * 			description="Server ID doesn't exist",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		),
	 * 		@OA\Response(
	 * 			response=500,
	 * 			description="Server error",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		)
	 * )
	 */
	public function players($id) {
		$response = $this->topic_wrapper($id, 'playerlist');
		if(is_array($response)) {
			if($response['statuscode'] == 200) {
				return response()->json($response['data']);
			} else {
				abort($response['statuscode'], $response['response']);
			}
		} else {
			abort(500, "Topic communication error");
		}
	}

	/**
	 * @OA\Get(
	 * 		path="/servers",
	 * 		summary="Get a list of servers registered with the API",
	 * 		description="Returns an array of the current servers the API is configured to interface with, including IP and port.",
	 * 		tags={"Server"},
	 * 		operationId="getServers",
	 * 		@OA\Response(
	 * 			response=200,
	 * 			description="List of registered servers",
	 * 			@OA\JsonContent(
	 * 				type="array",
	 * 				@OA\Items(ref="#/components/schemas/server")
	 * 			)
	 * 		),
	 * 		@OA\Response(
	 * 			response=500,
	 * 			description="Server error",
	 * 			@OA\JsonContent(ref="#/components/schemas/error")
	 * 		)
	 * )
	 */
	public function servers() {
		$outputServers = [];
		for($i=0; $i < count($this->servers); $i++) {
			// Minimize risk of accidental information disclosure
			$outputServers[$i]['name'] = $this->servers[$i]['name'];
			$outputServers[$i]['ip'] = $this->servers[$i]['public_ip'];
			$outputServers[$i]['port'] = $this->servers[$i]['port'];
		}
		return response()->json($outputServers);
	}

	/**
	 * Make a topic request to the server
	 *
	 * @param int $id ID of the target server
	 *
	 * @param string $endpoint String name of the target topic endpoint on the server
	 *
	 * @param array $data Additional parameters to add to the request
	 *
	 * @return float|string|array
	 * Either a float string or array, depending on the target server's response.
	 * If possible, string json data is decoded to an associative array.
	 */
	private function topic_wrapper($id, $endpoint, $data = []) {
		if($id >= count($this->servers)) {
			abort(404, "Server ID not found");
		}
		$query = [
			'auth' => $this->servers[$id]['token'],
			'source' => "AuAPI",
			'query' => $endpoint
		];
		$query = array_merge($query, $data);
		$response = $this->topic($id, $query);
		$decoded = json_decode(trim($response), true);
		return $decoded ? $decoded : $response;
	}

	/**
	 * Internal method for topic calls. Shouldn't be called directly by endpoints
	 *
	 * @param int $id
	 *
	 * @param array $query
	 *
	 * @return float|string
	 */
	private function topic($id, $query) {
		$query = json_encode($query, JSON_FORCE_OBJECT);
		$query = "\x00\x83" . pack('n', strlen($query) + 6) . "\x00\x00\x00\x00\x00" . $query . "\x00";

		$server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if(!$server || !socket_connect($server, $this->servers[$id]['ip'], $this->servers[$id]['port'])) {
			return false;
		}

		$bytes_sent = 0;
		while($bytes_sent < strlen($query)) {
			$result = socket_write($server, substr($query, $bytes_sent));
			if($result === false) {
				return false;
			}
			$bytes_sent += $result;
		}

		$response = socket_read($server, 100000);

		if($response != "") {
			if($response[0] == "\x00" || $response[1] == "\x83") { // make sure it's the right packet format

				// Actually begin reading the output:
				$sizebytes = unpack('n', $response[2] . $response[3]); // array size of the type identifier and content
				$size = $sizebytes[1] - 1; // size of the string/floating-point (minus the size of the identifier byte)

				if($response[4] == "\x2a") { // 4-byte big-endian floating-point
					$unpackint = unpack('f', $response[5] . $response[6] . $response[7] . $response[8]); // 4 possible bytes: add them up together, unpack them as a floating-point
					return $unpackint[1];
				}
				else if($response[4] == "\x06") { // ASCII string
					$unpackstr = ""; // result string
					$index = 5; // string index

					while($size > 0) { // loop through the entire ASCII string
						$size--;
						$unpackstr .= $response[$index]; // add the string position to return string
						$index++;
					}
					return $unpackstr;
				}
			}
		}
		return false;
	}
}
