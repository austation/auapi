<?php

// Literally just exists to specify API information for the linter lmfao

/**
 * OA\OpenApi(
 * 		@OA\Info(
 * 			title="AuAPI",
 * 			description="This is a collection of endpoints, which can be used to interact with and read information about AuStation SS13 servers.<br>For support, contact Terra#4852 directly on Discord, or through [AuStation's Discord server](https://discord.gg/ZTGQAqB)<br>Source code for this API can be found on [GitHub](https://github.com/austation/auapi)",
 * 			version="0.2.0",
 * 			@OA\License(name="MIT", url="https://mit-license.org")
 * 		),
 * 		@OA\Server(description="AuStation API", url="https://api.austation.net")
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
