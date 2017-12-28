# IPayNow-PHP
IPayNow-PHP-SDK
    使用方式
    $IPayNow = new IPayNow();
		$IPayNow->setApiId("abcdefghijklmnopqrstuvwxyz"); //Customise or write on cofig
		$IPayNow->setSecretKey("1234657890"));
		$IPayNow->setRedirectUrl("https://www.ipaynow.cn");
		$IPayNow->setNotifyUrl("https://www.ipaynow.cn");
		$IPayNow->setDisplayName("test");
		$IPayNow->setOrderDescription("test");
		$IPayNow->setOrderNumber("19847612516413131");
		$IPayNow->setProductDetail([
      {'name' => 'testProduct1', 'quantity' => 1},
      {'name' => 'testProduct2', 'quantity' => 2}
    ]);
		$IPayNow->setOrderAmount(650.00);
		$IPayNow->setCurrency('NZD');
		$IPayNow->Alipay();
		echo ($IPayNow->checkout()); //Rediect to this Url
