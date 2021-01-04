<?php


namespace App\Http\Controllers;


use App\Actions\MyValidator;
use App\Actions\ValidMessages;
use App\Actions\ValidRules;
use Illuminate\Http\Request;

class CalculateController extends Controller
{
    private array $data;

    private float $w;          // Loop count
    private float $lambda;     // Fill factor
    private float $G;          // Geometry factor
    private float $L;          // Wire length [m]
    private float $m;          // Wire mass [kg]
    private float $R;          // Wire resistance [Ohm]
    private float $V;          // Coil voltage [V]
    private float $W;          // Coil power [W]
    private float $B;          // Coil magnetic field [mT]
    private float $Li;         // Coil inductance [mH]

    public function calculateCoil(Request $request)
    {
        $err = null;
        $result = null;
        $chartBW = null;
        $chartRV = null;

        // Validate data
        $validator = new MyValidator();
        $err = $validator->validateData($request->input(), ValidRules::$calculateRules, ValidMessages::$calculateMessages);

        if($err == null) {
            // Calculate
            $this->data = $request->input();

            $this->w = $this->loopCount();
            $this->lambda = $this->fillFactor();
            $this->G = $this->geometryFactor();
            $this->L = $this->wireLength();
            $this->m = $this->wireMass();
            $this->R = $this->wireResistance($this->data['t0']);
            $this->B = $this->coilField($this->data['t0'], $this->data['I']);
            $this->V = $this->coilVoltage($this->data['I']);
            $this->W = $this->coilPower($this->data['I']);
            $this->Li = $this->coilInductance();

            // Create result
            $result['N']      = $this->w;
            $result['lambda'] = round($this->lambda, 4);
            $result['G']      = round($this->G, 4);
            $result['L']      = round($this->L, 4);
            $result['m']      = round($this->m, 6);
            $result['R']      = round($this->R, 4);
            $result['T']      = round($this->data['t0'],4);
            $result['I']      = round($this->data['I'],4);
            $result['V']      = round($this->V,4);
            $result['W']      = round($this->W,4);
            $result['B']      = round($this->B,4);
            $result['Li']     = round($this->Li,4);

            // Calculate Carts
            $chartBW = $this->chartBW();
            $chartRV = $this->chartRV();
        }

        return [
            'result'  => $result,
            'chartBW' => $chartBW,
            'chartRV' => $chartRV,
            'err'     => $err,
        ];
    }

    /**
     * @return float|int
     */
    private function alpha()
    {
        return $this->data['outer_d'] / $this->data['inner_d'];
    }

    /**
     * @return float|int
     */
    private function betta()
    {
        return $this->data['length'] / $this->data['inner_d'];
    }

    /**
     * @param $T
     * @return float|int
     */
    private function Ro($T)
    {
        return $this->data['resistivity'] * (1 + $this->data['alphaT'] * ($T - 20));
    }

    /**
     * @return float|int
     */
    private function loopCount()
    {
        return round($this->data['length'] / $this->data['full_d']) * round(($this->data['outer_d'] -
                    $this->data['inner_d']) / (2 * $this->data['full_d']));
    }

    /**
     * @return float|int
     */
    private function fillFactor()
    {
        return (pi() * pow($this->data['conductor_d'], 2) * $this->w) / (2 * $this->data['length'] *
                ($this->data['outer_d'] - $this->data['inner_d']));
    }

    /**
     * @return float|int
     */
    private function geometryFactor()
    {
        return (sqrt(2 * pi()) / 5) * sqrt($this->betta() / (pow($this->alpha(), 2) - 1)) *
            log(($this->alpha() + sqrt(pow($this->betta(), 2) + pow($this->alpha(),2))) /
                (1 + sqrt(pow($this->betta(),2) + 1)));
    }

    /**
     * @return float
     */
    private function wireLength()
    {
        return (($this->w * pi() * ($this->data['outer_d'] + $this->data['inner_d'])) / 2) * 1E-3;
    }

    /**
     * @return float|int
     */
    private function wireMass()
    {
        return (($this->data['density'] * pi() * pow($this->data['conductor_d'] * 1E-3,2)) / 4) * $this->L;
    }

    /**
     * @param float $T
     * @return float|int
     */
    private function wireResistance(float $T)
    {
        return ($this->Ro($T) * $this->L * 4) / (pi() * pow($this->data['conductor_d'] * 1E-3,2));
    }

    /**
     * @param float $I
     * @return float|int
     */
    private function coilVoltage(float $I)
    {
        return $this->R * $I;
    }

    /**
     * @param float $I
     * @return float|int
     */
    private function coilPower(float $I)
    {
        return $this->V * $I;
    }

    /**
     * @param float $T
     * @param float $I
     * @return float
     */
    private function coilField(float $T, float $I)
    {
        $W = pow($I,2) * $this->wireResistance($T);

        return ($this->G * sqrt(($W * $this->lambda) / ($this->Ro($T) * ($this->data['inner_d'] / 2) * 1E-3))) * 1E-3;
    }

    /**
     * @return float|int
     */
    private function coilInductance()
    {
        $averageR = ($this->data['inner_d'] + $this->data['outer_d']) / 4;
        $thicness = $this->data['outer_d'] - $this->data['inner_d'];

        return (0.02 * ((pow($averageR,2) * pow($this->w,2)) / (6 * $averageR + 9 * $this->data['length'] + 10 * $thicness))) / 1000;
    }

    /**
     * @return array[]
     */
    private function chartBW()
    {
        $chartB = [];
        $chartW = [];

        // calculate resistance
        $R = $this->wireResistance($this->data['TI']);

        for($i = $this->data['startI']; $i <= $this->data['endI']; $i += $this->data['stepI'])
        {
            $W = pow($i,2) * $R;
            $B = ($this->G * sqrt(($W * $this->lambda) / ($this->Ro($this->data['TI']) * ($this->data['inner_d'] / 2) * 1E-3))) * 1E-3;

            $chartB[] = [
                'x' => $i,
                'y' => $B,
            ];

            $chartW[] = [
                'x' => $i,
                'y' => $W,
            ];
        }

        return [$chartB, $chartW];
    }

    private function chartRV()
    {
        $chartR = [];
        $chartV = [];

        for ($i = $this->data['startT']; $i <= $this->data['endT']; $i += $this->data['stepT']) {
            $R = $this->wireResistance($i);
            $V = $R * $this->data['IT'];

            $chartR[] = [
                'x' => $i,
                'y' => $R,
            ];

            $chartV[] = [
                'x' => $i,
                'y' => $V,
            ];
        }

        return [$chartR, $chartV];
    }
}