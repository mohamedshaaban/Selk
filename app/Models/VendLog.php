<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VendLog extends Model {

	public function getNoteAttribute( $value ) {
		if ( json_decode( $value, true ) ) {
			return $value;
		}

		return $value;
	}

	public function setNoteAttribute( $value ) {
		if(is_array($value)) {
			return json_encode( $value);
		}

		return $value;
	}
}
