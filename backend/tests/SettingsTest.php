<?php


namespace App\Test;


use Selective\Config\Configuration;

class SettingsTest extends BaseTestCase
{

    public function testSetting() {
        $configuration = self::$container->get(Configuration::class);
        $uploadDir = $configuration->getString('uploads');
        var_dump($uploadDir);

}

}