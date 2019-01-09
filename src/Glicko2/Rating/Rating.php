<?php
namespace Diegobanos\Glicko2\Rating;

class Rating
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

    public function __construct(float $rating, float $ratingDeviation, float $volatility)
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
