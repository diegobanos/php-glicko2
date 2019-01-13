# php-glicko2

[![Build Status](https://travis-ci.org/diegobanos/php-glicko2.svg?branch=master)](https://travis-ci.org/diegobanos/php-glicko2)

A PHP glicko2 implementation with an easy to use interface.

## How to use

```php
use Diegobanos\Glicko2\Rating\Rating;
use Diegobanos\Glicko2\Result\Result;
use Diegobanos\Glicko2\Glicko2;

$glicko2 = new Glicko2;

$rating = new Rating(1500, 200);

$results = [
    new Result(new Rating(1400, 30), 1), //victory
    new Result(new Rating(1550, 100), 0), //defeat
    new Result(new Rating(1700, 300), 0) //defeat
];

$updatedRating = $glicko2->calculateRating($rating, $results);

//The updated rating will be (1464.06, 151.52, 0.05999)
```

You can also create your own `Rating` class that implements `Diegobanos\Glicko2\Rating\Rating\RatingInterface`.

## License

MIT License

## Further reading

The algorithm implemented on this project is described in the following [PDF](http://www.glicko.net/glicko/glicko2.pdf).
