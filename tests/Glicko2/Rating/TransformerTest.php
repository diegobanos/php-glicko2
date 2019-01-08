<?php
namespace Diegowc\Tests\Glicko2\Rating;

use Diegowc\Glicko2\Rating\Rating;
use Diegowc\Glicko2\Rating\Transformer;
use PHPUnit\Framework\TestCase;

class TransformerTest extends TestCase
{
    /**
     * @dataProvider getNormalizeData
     */
    public function testNormalizeRating($r, $rd, $v, $r2, $rd2)
    {
        $rating = new Rating($r, $rd, $v);
        $transformer = new Transformer;

        $normalizedRating = $transformer->normalizeRating($rating);

        $this->assertEquals($r2, $normalizedRating->getRating(), 'Error asserting normalized rating', 0.0001);
        $this->assertEquals($rd2, $normalizedRating->getRatingDeviation(), 'Error asserting normalized rating deviation', 0.0001);
    }

    public function getNormalizeData()
    {
        return [
            [1500, 200, 0.06, 0, 1.1513],
            [1400, 30, 0.06, -0.5756, 0.1727],
            [1550, 100, 0.06, 0.2878, 0.5756],
            [1700, 300, 0.06, 1.1513, 1.7269]
        ];
    }

    /**
     * @dataProvider getStandardizeData
     */
    public function testStandardizeRating($r, $rd, $v, $r2, $rd2)
    {
        $normalizedRating = new Rating($r, $rd, $v);
        $transformer = new Transformer;

        $rating = $transformer->standardizeRating($normalizedRating);

        $this->assertEquals($r2, $rating->getRating(), 'Error asserting standard rating', 0.01);
        $this->assertEquals($rd2, $rating->getRatingDeviation(), 'Error asserting standard rating deviation', 0.01);
    }

    public function getStandardizeData()
    {
        return [
            [0, 1.1513, 0.06, 1500, 200],
            [-0.5756, 0.1727, 0.06, 1400, 30],
            [0.2878, 0.5756, 0.06, 1550, 100],
            [1.1513, 1.7269, 0.06, 1700, 300]
        ];
    }
}
