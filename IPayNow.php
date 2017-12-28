<?php
namespace App\Http\IPayNow;

/**
 * @author Jayzee Huang
 * @version 0.1
 */
class IPayNow {

	protected $endPoint = 'https://gapi.ipaynow.cn/global';
	protected $secretKey = 'yhmpArx0Pn7DqqFpuYErDoikNVRud78t';
	protected $request = [
		"appId" => "1461826666666666",
		"deviceType" => "",
		"frontNotifyUrl" => "",
		"funcode" => "",
		"mhtAmtCurrFlag" => "1",
		"mhtCharset" => "UTF-8",
		"mhtCurrencyType" => "",
		"mhtOrderAmt" => "",
		"mhtOrderDetail" => "",
		"mhtOrderName" => "",
		"mhtOrderNo" => "",
		"mhtOrderStartTime" => "",
		"mhtOrderTimeOut" => "3600",
		"mhtOrderType" => "01",
		"mhtSignType" => "MD5",
		"notifyUrl" => "",
		"payChannelType" => "",
		"detail" => array("goods_detail" => []),
		"version" => "1",
		"mhtSignature" => "",
	];

	/**
	 * @param String|string $value [description]
	 */
	public function setApiId(String $value = '') {
		return $this->request['appId'] = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setSecretKey(String $value = '') {
		return $this->secretKey = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setRedirectUrl(String $value = '') {
		return $this->request['frontNotifyUrl'] = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setNotifyUrl(String $value = '') {
		return $this->request['notifyUrl'] = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setDisplayName(String $value = '') {
		return $this->request['mhtOrderName'] = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setOrderDescription(String $value = '') {
		return $this->request['mhtOrderDetail'] = $value;
	}

	/**
	 * @param String|string $value [description]
	 */
	public function setOrderNumber(String $value = '') {
		return $this->request['mhtOrderNo'] = $value;
	}

	/**
	 * @param [type] $value [description]
	 */
	public function setOrderAmount($value) {
		return $this->request['mhtOrderAmt'] = ceil($value * 100);
	}

	public function setCurrency(String $value = '') {
		return $this->request['mhtCurrencyType'] = $value;
	}

	/**
	 * [Alipay description]
	 */
	public function Alipay() {
		$this->request['deviceType'] = '06';
		return $this->request['payChannelType'] = 90;
	}

	/**
	 * [WeChatPay description]
	 */
	public function WeChatPay() {
		$this->request['deviceType'] = '02';
		return $this->request['payChannelType'] = 80;
	}

	/**
	 * @return [type] [description]
	 */
	public function sign() {
		return $this->request['mhtSignature'] = md5($this->joinString($this->request) . '&' . md5($this->secretKey));
	}

	/**
	 * @param  Array  $array [description]
	 * @return String        [description]
	 */
	public function joinString(Array $array) {
		ksort($array);
		reset($array);
		$joinString = '';
		foreach ($array as $key => $value) {
			if ($value === '' || $key === 'funcode' || $key === 'mhtSignType' || $key === 'deviceType' || $key === 'detail' || $key === 'version' || $key === 'signature' || $key === 'signType') {
				continue;
			}
			$joinString .= $key . '=' . $value . '&';
		}
		$joinString = substr($joinString, 0, strlen($joinString) - 1);
		return $joinString;
	}

	/**
	 * @param Array $array [description]
	 */
	public function setProductDetail(Array $array) {
		foreach ($array as $item) {
			array_push($this->request['detail']['goods_detail'], ['good_name' => $item['name'], "quantity" => $item['quantity']]);
		}
	}

	/**
	 * @param  Array  $array [description]
	 * @return String        [description]
	 */
	public function joinRequest(Array $array) {
		$requestString = '';
		foreach ($array as $key => $value) {
			if ($key === 'detail' || $key === 'version') {
				continue;
			}
			$value = urlencode($value);
			$requestString .= $key . '=' . $value . '&';
		}
		$requestString = substr($requestString, 0, strlen($requestString) - 1);
		return $requestString;
	}

	/**
	 * @return String [description]
	 */
	public function checkout() {
		$timeZone = date_default_timezone_set("Asia/Shanghai");
		$this->request['funcode'] = 'WP001';
		$this->request['mhtOrderStartTime'] = date("YmdHis");
		$this->sign();
		$requestUrl = $this->endPoint . '?' . $this->joinRequest($this->request);
		return $requestUrl;
	}

}