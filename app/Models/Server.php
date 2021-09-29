<?php

/**
 * @OA\Schema(schema="server",
 * 		type="object"
 * )
 */
class Server
{
	/**
	 * Name of the server
	 * @OA\Property()
	 * @var string
	 */
	public $name;

	/**
	 * IP address of the server
	 * @OA\Property()
	 * @var string
	 */
	public $ip;

	/**
	 * Port the server is bound to
	 * @OA\Property()
	 * @var int
	 */
	public $port;
}
