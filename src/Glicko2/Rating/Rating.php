<?php
namespace Diegobanos\Glicko2\Rating;

class Rating implements RatingInterface
{
    /**
     * @var float
     */
    private $rating;

    /**
     * @var float
     */
    private $ratingDeviation;

    /**
     * @var float
     */
    private $volatility;

    public function __construct(float $rating = 1500, float $ratingDeviation = 200, float $volatility = 0.06)
    {
        $this->rating = $rating;
        $this->ratingDeviation = $ratingDeviation;
        $this->volatility = $volatility;
    }

    public function getRating(): float
    {
        return $this->rating;
    }

    public function getRatingDeviation(): float
    {
        return $this->ratingDeviation;
    }

    public function getVolatility(): float
    {
        return $this->volatility;
    }
}
