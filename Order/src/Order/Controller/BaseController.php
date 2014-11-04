<?php
namespace Order\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\JsonModel;
use Zend\Http\Response;

class BaseController extends AbstractActionController {
	public function createJsonView($result, $status = Response::STATUS_CODE_200) {
		$this->getResponse()->setStatusCode($status);
		return new JsonModel($result);
	}
}