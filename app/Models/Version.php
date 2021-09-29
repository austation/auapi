<?php

/**
 * @OA\Schema(schema="version",
 * 		type="object"
 * )
 */
class Version
{
	/**
	 * Current version of the API
	 * @OA\Property()
	 * @var string
	 */
	public $version;
}
