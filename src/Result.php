<?php

namespace Abby;

/**
 * Result
 */
class Result
{
    private $experiment;

    private $minimumConfidence = 0.95;
    private $minimumDetectableEffect = 20;

    private $winner;
    private $confidence;
    private $confident;
    private $sampleSize;
    private $significant;

    /**
     * @param Experiment $experiment
     * @param array $options
     *
     * @return void
     */
    public function __construct(Experiment $experiment, $config = [])
    {
        $this->experiment = $experiment;

        // Set minimum confidence (if defined)
        if (isset($config['minimumConfidence'])) {
            $this->setMinimumConfidence($config['minimumConfidence']);
        }

        // Set minimum detectable effect (if defined)
        if (isset($config['minimumDetectableEffect'])) {
            $this->setMinimumDetectableEffect($config['minimumDetectableEffect']);
        }
    }

    /**
     * Calculate result
     * 
     * @return self
     */
    private function calculate()
    {
        $control = $this->experiment->getControl();
        $variation = $this->experiment->getVariation();

        $controlViews = $control->getViews();
        $controlConversions = $control->getConversions();
        $controlConversionRate = $control->getConversionRate();

        $variationViews = $variation->getViews();
        $variationConversions = $variation->getConversions();
        $variationConversionRate = $variation->getConversionRate();

        if (
             ($controlViews != 0 && $variationViews != 0) &&
            !($controlConversions == 0 && $variationConversions == 0) &&
             $controlConversionRate !== $variationConversionRate
        ) {
            $crA = $controlConversionRate;
            $crB = $variationConversionRate;

            // Check which variation is the winner
            $winner = ($crA > $crB) ? 0 : 1;

            // Set winner and loser groups
            $this->experiment->getGroup($winner)->setWinner();
            $this->experiment->getGroup(1 - $winner)->setLoser();

            // If control is winner, flip experiment and control for the remaining calculations
            if ($winner === 0) {
                list($controlViews, $variationViews) = array($variationViews, $controlViews);
                list($crA, $crB) = array($crB, $crA);
            }

            // Calculate standard error
            $seA = sqrt(($crA * (1 - $crA)) / $controlViews);
            $seB = sqrt(($crB * (1 - $crB)) / $variationViews);
            
            $seDiff = sqrt(pow($seA, 2) + pow($seB, 2));

            // Avoid division by zero when calculating zScore and confidence
            if (!!($crB - $crA) && !!$seDiff) {
                $zScore     = ($crB - $crA) / $seDiff;
                $confidence = $this->cdf($zScore, 0, 1);
                $confident  = $confidence >= $this->minimumConfidence;
            } else {
                $confidence = 0;
                $confident  = false;
            }

            // Calculate minimum sample size
            $sampleSize = $this->calculateSampleSize(
                $crA, $this->getMinimumConfidence(), $this->getMinimumDetectableEffect()
            );

            /**
             * Even if the results are confident (null hypothesis is rejected), the size
             * of both groups need to be greater than or equal to the minimum sample size
             * to consider the result statistically significant
             */

            $significant = min($controlViews, $variationViews) >= $sampleSize ? $confident : false;

            $this->winner      = $winner;
            $this->confidence  = $confidence;
            $this->confident   = $confident;
            $this->sampleSize  = $sampleSize;
            $this->significant = $significant;
        } else {
            $this->winner      = null;
            $this->confidence  = 0;
            $this->confident   = false;
            $this->sampleSize  = INF;
            $this->significant = false;
        }

        return $this;
    }

    /**
     * Error function
     * 
     * @param float $x
     * 
     * @return float
     */
    private function erf($x)
    {
        $cof = array(
            -1.3026537197817094, 6.4196979235649026e-1, 1.9476473204185836e-2,
            -9.561514786808631e-3, -9.46595344482036e-4, 3.66839497852761e-4,
            4.2523324806907e-5, -2.0278578112534e-5, -1.624290004647e-6,
            1.303655835580e-6, 1.5626441722e-8, -8.5238095915e-8,
            6.529054439e-9, 5.059343495e-9, -9.91364156e-10,
            -2.27365122e-10, 9.6467911e-11, 2.394038e-12,
            -6.886027e-12, 8.94487e-13, 3.13092e-13,
            -1.12708e-13, 3.81e-16, 7.106e-15,
            -1.523e-15, -9.4e-17, 1.21e-16,
            -2.8e-17
        );

        $isneg = !1;
        $d     = 0;
        $dd    = 0;

        if ($x < 0) {
            $x     = -$x;
            $isneg = !0;
        }

        $t  = 2 / (2 + $x);
        $ty = 4 * $t - 2;

        for ($j = count($cof) - 1; $j > 0; $j--) {
            $tmp = $d;
            $d   = $ty * $d - $dd + $cof[$j];
            $dd  = $tmp;
        }

        $res = $t * exp(-$x * $x + 0.5 * ($cof[0] + $ty * $d) - $dd);

        return ($isneg) ? $res - 1 : 1 - $res;
    }

    /**
     * Cumulative distribution function
     * 
     * @param float $zScore
     * @param float $mean
     * @param float $std
     * 
     * @return float
     */
    private function cdf($zScore, $mean, $std)
    {
        return 0.5 * (1 + $this->erf(($zScore - $mean) / sqrt(2 * $std * $std)));
    }

    /**
     * Calculate minimum sample size
     * 
     * @param float $controlConversionRate
     * @param int $minimumEffect
     * @param float minimumConfidence
     * 
     * @return int
     */
    private function calculateSampleSize($controlConversionRate, $minimumConfidence, $miminumEffect)
    {
        // We can't calculate a sample size without a conversion rate, so return an infinte number
        if ($controlConversionRate <= 0) {
            return INF;
        }

        // Set conficence and effect for our calculations
        $confidence = 1 - $minimumConfidence;
        $effect = $controlConversionRate * ($miminumEffect / 100);

        // Create a two-tailed test based on the minimum confidence and effect
        $c1 = $controlConversionRate;
        $c2 = $controlConversionRate - $effect;
        $c3 = $controlConversionRate + $effect;

        // Get absolute value of the effect
        $theta = abs($effect);

        // Create to variances by swapping $c1 and $c2
        $variance1 = $c1 * (1 - $c1) + $c2 * (1 - $c2);
        $variance2 = $c1 * (1 - $c1) + $c3 * (1 - $c3);

        // Look for the greatest absolute value of two possible sample estimates
        $estimate1 = 2 * (1 - $confidence) * $variance1 * log(1 + sqrt($variance1) / $theta) / ($theta * $theta);
        $estimate2 = 2 * (1 - $confidence) * $variance2 * log(1 + sqrt($variance2) / $theta) / ($theta * $theta);

        // Settle on the larger of the two calculated sizes to control the false discovery rate
        $sampleSize = abs($estimate1) >= abs($estimate2) ? $estimate1 : $estimate2;

        // If the calculated sample size is below zero or not a number, return an infinite number
        if ($sampleSize < 0 || !is_numeric($sampleSize)) {
            return INF;
        }

        // Round result to a significant figure
        $n = round($sampleSize);
        $m = pow(10, 2 - floor(log($n) / log(10)) - 1);

        return round(round($n * $m) / $m);
    }

    /**
     * Get the specified minimum confidence
     * 
     * @return float 
     */
    public function getMinimumConfidence()
    {
        return $this->minimumConfidence;
    }

    /**
     * Set the minimum confidence
     * 
     * @param float $confidence
     * 
     * @return self
     */
    public function setMinimumConfidence($confidence)
    {
        $this->minimumConfidence = $confidence;

        return $this;
    }

    /**
     * Get the specified minimum detectable effect
     * 
     * @return float 
     */
    public function getMinimumDetectableEffect()
    {
        return $this->minimumDetectableEffect;
    }

    /**
     * Set the minimum detectable effect
     * 
     * @param float $effect
     * 
     * @return self
     */
    public function setMinimumDetectableEffect($effect)
    {
        $this->minimumDetectableEffect = $effect;

        return $this;
    }

    /**
     * Get the winning group
     * 
     * @return Group|null
     */
    public function getWinner()
    {
        $this->calculate();

        if ($this->winner === null) {
            return null;
        }

        return $this->experiment->getGroup($this->winner);
    }

    /**
     * Get the losing group
     * 
     * @return Group|null
     */
    public function getLoser()
    {
        $this->calculate();

        if ($this->winner === null) {
            return null;
        }

        return $this->experiment->getGroup(1 - $this->winner);
    }

    /**
     * Get the percentual conversion rate change between the control and variation
     * 
     * @return float
     */
    public function getConversionRateChange()
    {
        $controlConversions = $this->experiment->getControl()->getConversions();
        $variationConversions = $this->experiment->getVariation()->getConversions();

        // Return zero if either or both groups have no conversion
        if (!$controlConversions || !$variationConversions) {
            return 0;
        }

        return round((
            $variationConversions - $controlConversions
        ) / $controlConversions * 100, 2);
    }

    /**
     * Get confidence of result
     * 
     * Returns the probability that the null hypothesis (the hypothesis that there
     * is no difference or no change between the two variants) can be rejected
     * 
     * This is called the alternative hypothesis (inverse of the probability value)
     * 
     * @return float
     */
    public function getConfidence()
    {
        $this->calculate();

        return $this->confidence;
    }

    /**
     * Return whether we can be confident of the result
     * 
     * This requires the confidence to be greater than or equal to the configured
     * minimum confidence
     * 
     * @return bool
     */
    public function isConfident()
    {
        $this->calculate();

        return $this->confident;
    }

    /**
     * Return whether the result is statistically significant
     * 
     * This requires both the confidence (alternative hypothesis, i.e. the inverse of the p-value)
     * to be high enough (based on the specified minimum confidence) that the null hypothesis
     * can be rejected, and the size of both groups to be greater than or equal to the minimum
     * sample size (which is in turn calculated based on the minimum detectable effect, and the
     * conversion rate of the control group)
     * 
     * @return bool
     */
    public function isSignificant()
    {
        $this->calculate();

        return $this->significant;
    }

    /**
     * Get minimum sample size for the current experiment
     * 
     * This is based on the control conversion rate, minimum confidence,
     * and minimum detectable change in conversion rate, and is calculated
     * using a two-tailed test with a false discovery rate control
     * 
     * @return int
     */
    public function getMinimumSampleSize()
    {
        $this->calculate();

        return $this->sampleSize;
    }

    /**
     * Get complete results
     * 
     * @return object
     */
    public function getAll()
    {
        $this->calculate();

        // Get winning and losing groups
        $winner = $this->getWinner();
        $loser  = $this->getLoser();

        // Return complete results
        return (object)[
            'winner' => $winner ? $winner->getValues() : null,
            'loser' => $loser ? $loser->getValues() : null,
            'conversionRateChange' => $this->getConversionRateChange(),
            'confidence' => $this->confidence,
            'minimumSampleSize' => $this->sampleSize,
            'confident' => $this->confident,
            'significant' => $this->significant
        ];
    }
}