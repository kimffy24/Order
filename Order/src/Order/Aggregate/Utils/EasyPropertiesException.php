<?php
namespace Order\Aggregate\Utils;

/**
 * 获取属性值是，出错抛出的异常
 * @author JiefzzLon
 *
 */
class EasyPropertiesException extends \Exception
{
    public function __construct($message='Exception occur in use EasyProperties', $code=null, $previous=null){
        parent::__construct($message, $code, $previous);
    }
}