<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
	protected $table = "ban";
	public $timestamps = false;
	// Literally 1984
	protected $hidden = [
							'ip',
							'computerid',
							'a_ip',
							'a_computerid',
							'hidden',
							'server_ip',
							'server_port',
							'applies_to_admins',
							'who',
							'adminwho',
							'unbanned_ip',
							'unbanned_computerid',
							'edits'
						];
}
