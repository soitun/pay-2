<?php

namespace Yansongda\Pay\Tests\Plugin\Wechat\Marketing\Transfer;

use Yansongda\Pay\Exception\Exception;
use Yansongda\Pay\Exception\InvalidParamsException;
use Yansongda\Pay\Plugin\Wechat\Marketing\Transfer\QueryReceiptPlugin;
use Yansongda\Pay\Rocket;
use Yansongda\Pay\Tests\TestCase;
use Yansongda\Supports\Collection;

class QueryReceiptPluginTest extends TestCase
{
    protected QueryReceiptPlugin $plugin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->plugin = new QueryReceiptPlugin();
    }

    public function testModeWrong()
    {
        $rocket = new Rocket();
        $rocket->setParams(['_config' => 'service_provider']);

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::PARAMS_PLUGIN_ONLY_SUPPORT_NORMAL_MODE);
        self::expectExceptionMessage('参数异常: 查询转账账单电子回单接口，只支持普通商户模式，当前配置为服务商模式');

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testEmptyPayload()
    {
        $rocket = new Rocket();

        self::expectException(InvalidParamsException::class);
        self::expectExceptionCode(Exception::PARAMS_NECESSARY_PARAMS_MISSING);
        self::expectExceptionMessage('参数异常: 查询转账账单电子回单接口，参数缺少 `out_batch_no`');

        $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });
    }

    public function testNormalParams()
    {
        $rocket = new Rocket();
        $rocket->setPayload(new Collection( [
            "out_batch_no" => "111",
            'out_detail_no' => '222',
        ]));

        $result = $this->plugin->assembly($rocket, function ($rocket) { return $rocket; });

        self::assertEquals([
            '_method' => 'GET',
            '_url' => 'v3/transfer/bill-receipt/111',
        ], $result->getPayload()->all());
    }
}