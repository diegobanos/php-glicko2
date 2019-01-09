<?php
namespace Diegobanos\Tests\Glicko2\Volatility;

use Diegobanos\Glicko2\Volatility\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testCalculateVolatility()
    {
        $volatility = 0.06;
        $t = -0.4834;
        $rd = 0;
        $v = 1.7785;
        $calculator = new Calculator(0.5, 0.000001);

        $newVolatility = $calculator->calculateVolatility($volatility, $t, $rd, $v);

        $this->assertEquals(0.05999, $newVolatility, 'The volatility calculation failed', 0.00001);
    }
}
