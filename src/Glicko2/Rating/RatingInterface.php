<?php
namespace Diegobanos\Glicko2\Rating;

interface RatingInterface
{
    /**
     * Returns the rating of the player
     *
     * @return float
     */
    public function getRating(): float;

    /**
     * Returns the rating deviation of the player's rating
     *
     * @return float
     */
    public function getRatingDeviation(): float;

    /**
     * Returns the volatility of the player's rating
     *
     * @return float
     */
    public function getVolatility(): float;
}
