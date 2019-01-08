<?php
namespace Diegobanos\Glicko2;

use Diegobanos\Glicko2\Rating\Rating;

class Result
{
    /**
     * @var Rating
     */
    private $rating;

    /**
     * @var float
     */
    private $result;

    public function __construct(Rating $rating, float $result)
    {
        $this->rating = $rating;
        $this->result = $result;
    }

    public function getRating(): Rating
    {
        return $this->rating;
    }

    public function getResult(): float
    {
        return $this->result;
    }
}
