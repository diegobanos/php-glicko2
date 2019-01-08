<?php
namespace Diegobanos\Glicko2\Volatility;

class Calculator
{
    /**
     * @var float
     */
    private $tau;

    /**
     * @var float
     */
    private $tol;

    public function __construct(float $tau, float $tol)
    {
        $this->tau = $tau;
        $this->tol = $tol;
    }

    public function calculateVolatility(float $volatility, float $t, float $rd, float $v): float
    {
        $A = $a = log(pow($volatility, 2));

        if (pow($t, 2) > (pow($rd, 2) + $v)) {
            $B = log(pow($t, 2) - pow($rd, 2) - $v);
        } elseif (pow($t, 2) <= (pow($rd, 2) + $v)) {
            $k = 1;

            while ($this->f($a - ($k * $this->tau), $a, $t, $rd, $v) < 0) {
                $k++;
            }

            $B = $a - ($k * $this->tau);
        }

        $fA = $this->f($A, $a, $t, $rd, $v);
        $fB = $this->f($B, $a, $t, $rd, $v);

        while (abs($B - $A) > $this->tol) {
            $C = $A + ((($A - $B)*$fA)/($fB - $fA));
            $fC = $this->f($C, $a, $t, $rd, $v);

            if (($fC * $fB) < 0) {
                $A = $B;
                $fA = $fB;
            } else {
                $fA = $fA / 2;
            }

            $B = $C;
            $fB = $fC;
        }

        return exp($A / 2);
    }

    private function f(float $x, float $a, float $t, float $rd, float $v): float
    {
        return ((exp($x)*(pow($t, 2) - pow($rd, 2) - $v - exp($x))) / (2*pow(pow($rd, 2) + $v + exp($x), 2))) - (($x - $a) / $this->tau);
    }
}
