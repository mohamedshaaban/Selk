<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StatusHistory
 * @package App\Models
 *
 * @mixin \Eloquent
 */

class StatusHistory extends Model {
	protected $table = "status_history";

	protected $fillable = [ 'order_id', 'order_status_id', 'comment' ];

	public function status_history() {
		return $this->belongsTo( OrderStatus::class, 'order_status_id' );
	}


}
