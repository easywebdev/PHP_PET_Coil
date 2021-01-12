<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

    <title>Coil {{ $selectedCoil->name }}</title>

    <!-- Scripts -->
    <!--<script src="{{asset('js/jquery-3.3.1.js')}}" type="application/javascript"></script>-->
    <!--<script src="{{asset('js/chart.js')}}" type="application/javascript"></script>-->

    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/reset.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pdf.css') }}" rel="stylesheet">
</head>

<body>
    <h1>Coil "{{ $selectedCoil->name }}"</h1>

    <!-- Coil data -->
    <div class="block">
        <div id="design" class="block__item w-design">
            <h2>Design</h2>
            <div class="design">
                <div class="inner-d">{{ $selectedCoil->design->inner_d }}</div>
                <div class="outer-d">{{ $selectedCoil->design->outer_d }}</div>
                <div class="length">{{ $selectedCoil->design->length }}</div>
            </div>
        </div>
        <div class="block__item w-wire">
            <div class="mb-10px">
                <h2>Wire</h2>
                <div class="wire">
                    <div class="conductor-d">{{ $selectedCoil->wire->conductor_d }}</div>
                    <div class="full-d">{{ $selectedCoil->wire->full_d }}</div>
                </div>
            </div>
            <div>
                <h2>Material</h2>
                <table class="tbl-material">
                    <tr>
                        <td>Destiny</td>
                        <td>{{ $selectedCoil->wire->material->density }}</td>
                        <td>[kg/m<sup>3</sup>]</td>
                    </tr>
                    <tr>
                        <td>Resistivity</td>
                        <td>{{ $selectedCoil->wire->material->resistivity }}</td>
                        <td>[&Omega;/m]</td>
                    </tr>
                    <tr>
                        <td>TKR</td>
                        <td>{{ $selectedCoil->wire->material->alphaT }}</td>
                        <td>[1/K]</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="block__item w-operation">
            <h2>Operation mode</h2>
            <table class="tbl-operation">
                <tr>
                    <td>Current, I</td>
                    <td>{{ $I }}</td>
                    <td>[A]</td>
                </tr>
                <tr>
                    <td>Temperature, T</td>
                    <td>{{ $t0 }}</td>
                    <td>[&deg;C]</td>
                </tr>
            </table>
        </div>
    </div>

    <!-- Calculations results -->
    <div>
        <h2>Calculated parameters</h2>

        <table class="tbl-calculated">
            <thead>
            <tr>
                <th class="ta-l">Parameter</th>
                <th>Value</th>
                <th>Units</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="ta-l">Loop count (N)</td>
                <td id="N">{{ $result['N'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="ta-l">Fill factor (λ)</td>
                <td id="lambda">{{ $result['lambda'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="ta-l">Geometry factor (G)</td>
                <td id="G">{{ $result['G'] }}</td>
                <td></td>
            </tr>
            <tr>
                <td class="ta-l">Wire length (l)</td>
                <td id="L">{{ $result['L'] }}</td>
                <td>[m]</td>
            </tr>
            <tr>
                <td class="ta-l">Wire mass (m)</td>
                <td id="m">{{ $result['m'] }}</td>
                <td>[kg]</td>
            </tr>
            <tr>
                <td class="ta-l">Wire resistance (R)</td>
                <td id="R">{{ $result['R'] }}</td>
                <td>[&Omega;]</td>
            </tr>
            <tr>
                <td class="ta-l">Temperature (T)</td>
                <td id="T">{{ $result['T'] }}</td>
                <td>[&deg;C]</td>
            </tr>
            <tr>
                <td class="ta-l">Current (I)</td>
                <td id="II">{{ $result['I'] }}</td>
                <td>[A]</td>
            </tr>
            <tr>
                <td class="ta-l">Voltage (V)</td>
                <td id="V">{{ $result['V'] }}</td>
                <td>[V]</td>
            </tr>
            <tr>
                <td class="ta-l">Power (W)</td>
                <td id="W">{{ $result['W'] }}</td>
                <td>[W]</td>
            </tr>
            <tr>
                <td class="ta-l">Magnetic field (B)</td>
                <td id="B">{{ $result['B'] }}</td>
                <td>[mT]</td>
            </tr>
            <tr>
                <td class="ta-l">Inductance (L)</td>
                <td id="Li">{{ $result['Li'] }}</td>
                <td>[mH]</td>
            </tr>
            </tbody>
        </table>
    </div>

    <!--
    <script src="{{asset('js/build_chart.js')}}" type="application/javascript"></script>
    <script src="{{asset('js/pdf.js')}}" type="application/javascript"></script>


    <script type="application/javascript">
        app.alert({cMsg:"Message", cTitle: "Title"});
    </script>
    -->

</body>

</html>

