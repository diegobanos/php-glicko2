<?php
namespace Diegobanos\Glicko2\Result;

use Diegobanos\Glicko2\Rating\RatingInterface;

class Result implements ResultInterface
{
    /**
     * @var RatingInterface
     */
    private $rating;

    /**
     * @var float
     */
    private $result;

    public function __construct(RatingInterface $rating, float $result)
    {
        $this->rating = $rating;
        $this->result = $result;
    }

    public function getRating(): RatingInterface
    {
        return $this->rating;
    }

    public function getResult(): float
    {
        return $this->result;
    }
}
