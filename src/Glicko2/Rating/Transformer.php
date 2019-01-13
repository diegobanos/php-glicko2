<?php
namespace Diegobanos\Glicko2\Rating;

class Transformer
{
    public function normalizeRating(RatingInterface $rating): RatingInterface
    {
        return new Rating(($rating->getRating() - 1500) / 173.7178, $rating->getRatingDeviation() / 173.7178, $rating->getVolatility());
    }

    public function standardizeRating(RatingInterface $rating): RatingInterface
    {
        return new Rating($rating->getRating() * 173.7178 + 1500, $rating->getRatingDeviation() * 173.7178, $rating->getVolatility());
    }
}
