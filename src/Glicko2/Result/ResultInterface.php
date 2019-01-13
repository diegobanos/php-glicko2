<?php
namespace Diegobanos\Glicko2\Result;

use Diegobanos\Glicko2\Rating\RatingInterface;

interface ResultInterface
{
    /**
     * The rating of the rival player
     *
     * @return RatingInterface
     */
    public function getRating(): RatingInterface;

    /**
     * The result of the match
     *
     * - If the player lost the match, result equals 0
     * - If the player won the match, result equals 1
     * - If the players tied the match, result equals 0.5
     *
     * @return float
     */
    public function getResult(): float;
}
