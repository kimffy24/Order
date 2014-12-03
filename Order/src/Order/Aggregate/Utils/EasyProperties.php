<?php
namespace Order\Aggregate\Utils;

use Order\Service\Utils\PersistInterface;

/**
 * @desc 魔术方法会吧函数名全部转换为小写，注意使用
 * @author JiefzzLon
 *
 */
abstract class EasyProperties implements PersistInterface
{
    protected $keys = array();
    protected $params;
    /**
     * get/set屬性
     * 通過php魔術方法來實現get/set
     */
    public function __call($method,$args){
        $op = strtolower(substr($method, 0,3));
        $target = strtolower(substr($method, 3));
        if(!in_array($target, $this->keys))
            return;
        switch($op){
            case 'get':
                return $this->params[$target];
            case 'set':
                $this->params[$target]=$args[0];
            default:
                return;
        }
        
    }
	/**
     * @see \Order\Service\Utils\PersistInterface::getParamsCopy()
     */
    public function getParamsCopy()
    {
        return $this->params;
    }
}