<?php

namespace Order\Aggregate\Utils;

interface AggregateInterface {
    /**
     * @desc 獲取聚合跟根識符
     */
    public function getId();
}