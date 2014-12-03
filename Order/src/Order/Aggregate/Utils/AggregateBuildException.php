<?php

namespace Order\Aggregate\Utils;

class AggregateBuildException extends \Exception {
	public function __construct($message = 'Aggregate occur exception during on build.', $code = null, $previous = null) {
		parent::__construct ( $message, $code, $previous );
	}
}