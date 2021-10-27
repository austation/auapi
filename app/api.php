<?php

// Literally just exists to specify API information for the linter lmfao

/**
 * OA\OpenApi(
 * 		@OA\Info(
 * 			title="AuAPI",
 * 			description="This is a collection of endpoints, which can be used to interact with and read information about AuStation SS13 servers.<br>For support, contact Terra#4852 directly on Discord, or through [AuStation's Discord server](https://discord.gg/ZTGQAqB)<br>Source code for this API can be found on [GitHub](https://github.com/austation/auapi)",
 * 			version="0.4.2",
 * 			@OA\License(name="MIT", url="https://mit-license.org")
 * 		),
 * 		@OA\Server(description="AuStation API", url="https://api.austation.net")
 * )
 */

// Some schemas

/**
 * @OA\Schema(
 * 		schema="version",
 * 		type="object",
 * 		required={"version"},
 * 		@OA\Property(
 * 			property="version",
 * 			description="SemVer 2.0.0 string denoting current API version",
 * 			type="string"
 * 		)
 * )
 */

/**
 * @OA\Schema(
 * 		schema="server",
 * 		type="object",
 * 		required={"id", "name", "ip", "port"},
 * 		@OA\Property(
 * 			property="id",
 * 			description="Numeric identifier for the server, used to access API endpoints",
 * 			type="number",
 * 			format="int32"
 * 		),
 * 		@OA\Property(
 * 			property="name",
 * 			description="Human-readable name of the server",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="ip",
 * 			description="IP address the server is live at",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="port",
 * 			description="Port the server is running on",
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
 * 			description="Simple string describing the error",
 * 			type="string"
 * 		)
 * )
 */

/**
 * @OA\Schema(
 * 		schema="ban",
 * 		type="object",
 * 		required={"id", "bantime", "round_id", "role", "expiration_time", "reason", "ckey", "a_ckey", "unbanned_datetime", "unbanned_ckey", "unbanned_round_id", "server_name", "global_ban"},
 * 		@OA\Property(
 * 			property="id",
 * 			description="Numeric ID for the ban",
 * 			type="number",
 * 			format="int32"
 * 		),
 * 		@OA\Property(
 * 			property="bantime",
 * 			description="Timestamp for when the ban was applied as 'YYYY-MM-DD HH:MM:SS' Timestamp in 24 hour format",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="round_id",
 * 			description="Round ID when the ban was applied",
 * 			type="number",
 * 			format="int32"
 * 		),
 * 		@OA\Property(
 * 			property="role",
 * 			description="Role the ban is for",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="expiration_time",
 * 			description="Timestamp for when the ban will expire. NULL if permanent",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="reason",
 * 			description="Admin-provided reason the ban was applied",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="ckey",
 * 			description="Player key the ban applies to",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="a_ckey",
 * 			description="Key of the banning admin",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="unbanned_datetime",
 * 			description="Timestamp for when the ban was removed. NULL if ban still active",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="unbanned_ckey",
 * 			description="Key of the unbanning admin. NULL if ban still active",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="unbanned_round_id",
 * 			description="Round ID when the ban was removed. NULL if ban still active",
 * 			type="number",
 * 			format="int32"
 * 		),
 * 		@OA\Property(
 * 			property="server_name",
 * 			description="Name of the server the player was banned on",
 * 			type="string"
 * 		),
 * 		@OA\Property(
 * 			property="global_ban",
 * 			description="Whether the ban applies to all servers sharing the database (0 or 1)",
 * 			type="number",
 * 			format="int32"
 * 		)
 * )
 */
