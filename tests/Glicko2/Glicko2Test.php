<?php
namespace Diegowc\Tests\Glicko2;

use Diegowc\Glicko2\Glicko2;
use Diegowc\Glicko2\Rating\Rating;
use Diegowc\Glicko2\Result;
use PHPUnit\Framework\TestCase;

class Glicko2Test extends TestCase
{
    public function testcalculateRating()
    {
        $glicko2 = new Glicko2(0.5, 0.000001);

        $rating = new Rating(1500, 200, 0.06);

        $results = [
            new Result(new Rating(1400, 30, 0.06), 1),
            new Result(new Rating(1550, 100, 0.06), 0),
            new Result(new Rating(1700, 300, 0.06), 0)
        ];

        $newRating = $glicko2->calculateRating($rating, $results);

        $this->assertEquals(1464.06, $newRating->getRating(), 'Rating is not the expected', 0.01);
        $this->assertEquals(151.52, $newRating->getRatingDeviation(), 'Rating deviation is not the expected', 0.01);
        $this->assertEquals(0.05999, $newRating->getVolatility(), 'Volatility is not the expected', 0.00001);
    }
}
