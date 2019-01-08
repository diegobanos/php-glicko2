<?php
namespace Diegobanos\Glicko2;

use Diegobanos\Glicko2\Rating\Rating;
use Diegobanos\Glicko2\Rating\Transformer;
use Diegobanos\Glicko2\Volatility\Calculator;

class Glicko2
{
    /**
     * @var Calculator
     */
    private $calculator;

    /**
     * @var Transformer
     */
    private $transformer;

    public function __construct(float $tau, float $tol)
    {
        $this->calculator = new Calculator($tau, $tol);
        $this->transformer = new Transformer;
    }

    public function calculateRating(Rating $rating, array $results): Rating
    {
        $normalizedRating = $this->transformer->normalizeRating($rating);
        $normalizedResults = [];

        foreach ($results as $result) {
            $normalizedResults[] = new Result($this->transformer->normalizeRating($result->getRating()), $result->getResult());
        }

        $funcResults = [];

        foreach ($normalizedResults as $normalizedResult) {
            $funcResults[] = [
                'u' => $normalizedResult->getRating()->getRating(),
                'o' => $normalizedResult->getRating()->getRatingDeviation(),
                'g' => $this->g($normalizedResult->getRating()->getRatingDeviation()),
                'E' => $this->E($normalizedRating->getRating(), $normalizedResult->getRating()->getRating(), $normalizedResult->getRating()->getRatingDeviation()),
                's' => $normalizedResult->getResult()
            ];
        }

        $v = $this->v($funcResults);
        $t = $this->t($v, $funcResults);

        $newVolatility = $this->calculator->calculateVolatility($normalizedRating->getVolatility(), $t, $normalizedRating->getRatingDeviation(), $v);
        $newRatingDeviationScore = $this->calculateRatingDeviation($normalizedRating->getRatingDeviation(), $v, $newVolatility);
        $newRatingScore = $this->calculateNewRating($normalizedRating->getRating(), $newRatingDeviationScore, $funcResults);

        $newRating = new Rating($newRatingScore, $newRatingDeviationScore, $newVolatility);

        return $this->transformer->standardizeRating($newRating);
    }

    private function calculateNewRating(float $rating, float $newRatingDeviation, array $funcResults): float
    {
        return $rating + pow($newRatingDeviation, 2) * array_sum(array_map(function($r) { return $r['g'] * ($r['s'] - $r['E']); }, $funcResults));
    }

    private function preRatingDeviation(float $ratingDeviation, float $newVolatility): float
    {
        return sqrt(pow($ratingDeviation, 2) + pow($newVolatility, 2));
    }

    private function calculateRatingDeviation(float $ratingDeviation, float $v, float $newVolatility): float
    {
        return 1 / sqrt((1 / pow($this->preRatingDeviation($ratingDeviation, $newVolatility), 2)) + (1 / $v));
    }

    private function g(float $ratingDeviation): float
    {
        return 1 / sqrt(1 + (3 * pow($ratingDeviation, 2))/pow(pi(), 2));
    }

    private function E(float $rating, float $ratingj, float $rdj): float
    {
        return 1 / (1 + exp(-$this->g($rdj) * ($rating - $ratingj)));
    }

    private function v(array $funcResults): float
    {
        return pow(array_sum(array_map(function($r) { return pow($r['g'], 2) * $r['E'] * (1 - $r['E']);}, $funcResults)),-1);
    }

    private function t(float $v, array $funcResults): float
    {
        return $v * array_sum(array_map(function($r) { return $r['g'] * ($r['s'] - $r['E']); }, $funcResults));
    }
}
