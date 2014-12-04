<?php
namespace Order\Aggregate\Utils;

use Order\Service\Utils\PersistInterface;

/**
 * 封装一个简单的属性控制对象
 * @desc 魔术方法会吧函数名全部转换为小写，注意使用
 * @author JiefzzLon
 *
 */
abstract class EasyProperties implements PersistInterface
{
    private $raw = array();
    private $params;

    
    /**
     * 构造函数
     * @param array $keys
     */
    public function __construct(array $keys=array()){
        foreach($keys as $v){
            $mapKey = self::formatName($v);
            $this->raw[$v] = $mapKey;
            $this->params[$mapKey]['value'] = null;
            $this->params[$mapKey]['name'] = $v;
        }
    }
    /**
     * get/set屬性
     * 通過php魔術方法來實現get/set
     */
    public function __call($method,$args){
        $analyze = $this->analyzeOperation($method);
        $op = $analyze['op'];
        $target = $analyze['target'];
        if(!key_exists($target, $this->params))
            return;
        switch($op){
            case 'get':
                return $this->params[$target]['value'];
            case 'set':
                $this->params[$target]['value']=$args[0];
            default:
                return;
        }
    
    }
    /**
     * @see \Order\Service\Utils\PersistInterface::getParamsCopy()
     */
    public function getParamsCopy()
    {
        $params = array();
        foreach($this->params as $v)
            $params[$v['name']] = ($v['value'] instanceof EasyProperties)?$v['value']->getParamsCopy():$v['value'];
        return $params;
    }
    
    /**
     * 分析魔术调用中传入的函数名
     * @param string $method
     * @return array
     */
    protected function analyzeOperation($method){
        $tmp = self::formatName($method);
        return array('op'=>substr($tmp, 0,3), 'target'=>substr($tmp, 3));
    }
    /**
     * 获取被转化的映射键
     * @param string $raw_key
     * @throws EasyPropertiesException
     * @return string:
     */
    protected function getMapKey($raw_key){
        if(key_exists($raw_key, $this->raw))
            return $this->raw[$raw_key];
        throw new EasyPropertiesException();
    }
    /**
     * 获取规则化名称
     * @param string $rawName
     * @return string
     */
    static protected function formatName($rawName){
        return strtolower(str_replace('_', '', $rawName));
    }
}