<?php

namespace Order\Aggregate;

interface AggregateAwareInterface {
	public function setAggregate(AggregateInterface $a);
	public function getAggregate();
}