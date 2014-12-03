<?php

namespace Order\Aggregate\Utils;

interface AggregateInterface {
    /**
     * @desc 獲取聚合跟標識符
     */
    public function getId();
}