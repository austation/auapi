<?php

// Literally just exists to specify API information for the linter lmfao

/**
 * OA\OpenApi(
 * 		@OA\Info(title="AuAPI", version="0.2.0", @OA\License(name="MIT")),
 * 		@OA\Server(description="AuStation API", url="api.austation.net")
 * )
 */

// Some schemas that are too small for their own files

/**
 * @OA\Schema(
 * 		schema="version",
 * 		type="object",
 * 		required={"version"},
 * 		@OA\Property(
 * 			property="version",
 * 			type="string"
 * 		)
 * )
 */

/**
 * @OA\Schema(
 * 		schema="server",
 * 		type="object",
 * 		required={"name", "ip", "port"},
 * 		@OA\Property(
 * 			property="name",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="ip",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="port",
 * 			type="number",
 * 			format="int32"
 * 		)
 * )
 */

/**
 * @OA\Schema(
 * 		schema="error",
 * 		type="object",
 * 		required={"error"},
 * 		@OA\Property(
 * 			property="error",
 * 			type="string"
 * 		)
 * )
 */
