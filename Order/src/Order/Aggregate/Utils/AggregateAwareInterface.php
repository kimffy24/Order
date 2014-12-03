<?php

namespace Order\Aggregate\Utils;

interface AggregateAwareInterface {
	public function setAggregate(AggregateInterface $a);
	public function getAggregate();
}