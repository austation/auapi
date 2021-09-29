<?php

/**
 * @OA\Schema(schema="status",
 * 		type="object"
 * )
 */
class Status
{
	/**
	 * String specifying server codebase version
	 * @OA\Property()
	 * @var string
	 */
	public $version;

	/**
	 * Currently active gamemode on the server
	 * @OA\Property()
	 * @var string
	 */
	public $mode;

	/**
	 * Whether respawning is enabled
	 * @OA\Property()
	 * @var boolean
	 */
	public $respawn;

	/**
	 * Whether new players can enter the game
	 * @OA\Property()
	 * @var boolean
	 */
	public $enter;

	/**
	 * Whether players can create votes
	 * @OA\Property()
	 * @var boolean
	 */
	public $vote;

	/**
	 * Whether the AI job is enabled
	 * @OA\Property()
	 * @var boolean
	 */
	public $ai;

	/**
	 * Name of the server host
	 * @OA\Property()
	 * @var string
	 */
	public $host;

	/**
	 * Current round ID
	 * @OA\Property()
	 * @var int
	 */
	public $round_id;

	/**
	 * Number of players online
	 * @OA\Property()
	 * @var int
	 */
	public $players;

	/**
	 * Currently running Git revision (commit)
	 * @OA\Property()
	 * @var string
	 */
	public $revision;

	/**
	 * Date of currently running Git revision (commit)
	 * @OA\Property()
	 * @var string
	 */
	public $revision_date;

	/**
	 * Whether the server is listed on the BYOND hub
	 * @OA\Property()
	 * @var boolean
	 */
	public $hub;

	/**
	 * Current number of online admins
	 * @OA\Property()
	 * @var int
	 */
	public $admins;

	/**
	 * Indicates the current state of the game: 0 = Server Starting, 1 = Pregame Lobby, 2 = Starting Game, 3 = Game Running (Playing), 4 = Round Over
	 * @OA\Property()
	 * @var int
	 */
	public $gamestate;

	/**
	 * Currently active map
	 * @OA\Property()
	 * @var string
	 */
	public $map_name;

	/**
	 * Current security level (can be "green", "blue", "red" or "delta")
	 * @OA\Property()
	 * @var string
	 */
	public $security_level;

	/**
	 * Time the round has been running, in seconds
	 * @OA\Property()
	 * @var int
	 */
	public $round_duration;

	/**
	 * Current server time dilation (percentage)
	 * @OA\Property()
	 * @var float
	 */
	public $time_dilation_current;

	/**
	 * Averaged time dilation
	 * @OA\Property()
	 * @var float
	 */
	public $time_dilation_avg;

	/**
	 * Averaged time dilation over a longer period
	 * @OA\Property()
	 * @var float
	 */
	public $time_dilation_avg_slow;

	/**
	 * Averaged time dilation over a shorter period
	 * @OA\Property()
	 * @var float
	 */
	public $time_dilation_avg_fast;

	/**
	 * Number of living players at which new players will receive a warning about high population
	 * @OA\Property()
	 * @var int
	 */
	public $soft_popcap;

	/**
	 * Number of living players at which new players will be unable to spawn on the station
	 * @OA\Property()
	 * @var int
	 */
	public $hard_popcap;

	/**
	 * Number of living players at which players will be unable to join the server at all
	 * @OA\Property()
	 * @var int
	 */
	public $extreme_popcap;

	/**
	 * General value which is the maximum of soft, hard and extreme popcap values
	 * @OA\Property()
	 * @var int
	 */
	public $popcap;

	/**
	 * Current state of the emergency shuttle: "idle, "igniting", "recalled", "called", "docked", "stranded", "escape", "endgame: game over", "recharging", "landing"
	 * @OA\Property()
	 * @var string
	 */
	public $shuttle_mode;

	/**
	 * Current time left until the emergency shuttle completes its current operation
	 * @OA\Property()
	 * @var int
	 */
	public $shuttle_timer;
}
