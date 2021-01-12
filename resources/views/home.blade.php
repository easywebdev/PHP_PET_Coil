@extends('layout')

@section('content')
    <main class="s-main">
        <form id="coildata" name="coildata" method="post" action="{{ route('pdf') }}">
            @csrf
            <section class="coil container p-1rem bb mb-1rem">
                <h2 class="h2">Coil</h2>
                <div class="block">
                    <select id="coil" class="mr-1rem" name="coil_id">
                        @for($i = 0; $i < count($coilList); $i++)
                            <option value="{{ $coilList[$i]->id }}"@if($coilList[$i]->id == $coilID) selected @endif>{{ $coilList[$i]->name }}</option>
                        @endfor
                    </select>
                    <a class="btn mr-1rem" href="javascript:delCoil()">Delete</a>
                    <a class="btn mr-1rem" href="javascript:saveCoil()">Save</a>
                    <a class="btn mr-1rem" href="{{ route('new') }}">New Coil</a>
                    <input class="btn cursor-pointer" type="submit" value="Get PDF">
                </div>
            </section>

            <section class="container p-1rem bb mb-1rem">

                    <div class="block">
                        <div class="block__item mr-1rem">
                            <!-- Design -->
                            <div class="mb-05rem">
                                <h2 class="h2">Design</h2>
                                <select id="design" name="design_id">
                                    @for($i = 0; $i < count($designList); $i++)
                                        <option value="{{ $designList[$i]->id }}" @if($designList[$i]->id == $selectedCoil->design->id) selected @endif>{{ $designList[$i]->name }}</option>
                                    @endfor
                                </select>
                                <a class="btn" href="javascript:delDesign()">Delete</a>
                            </div>
                            <div class="design">
                                <input class="inner-d" type="text" id="inner_d" name="inner_d" value="{{ $selectedCoil->design->inner_d }}">
                                <input class="outer-d" type="text" id="outer_d" name="outer_d" value="{{ $selectedCoil->design->outer_d }}">
                                <input class="length" type="text" id="length" name="length" value="{{ $selectedCoil->design->length }}">
                            </div>

                        </div>
                        <div class="block__item mr-1rem">
                            <div class="mb-1rem">
                                <!-- Wire -->
                                <div class="mb-05rem">
                                    <h2 class="h2">Wire</h2>
                                    <select id="wire" name="wire_id">
                                        @for($i = 0; $i < count($wireList); $i++)
                                            <option value="{{ $wireList[$i]->id }}" @if($wireList[$i]->id == $selectedCoil->wire->id) selected @endif>{{ $wireList[$i]->name }}</option>
                                        @endfor
                                    </select>
                                    <a class="btn" href="javascript:delWire()">Delete</a>
                                </div>
                                <div class="wire">
                                    <input class="conductor-d" type="text" id="conductor_d" name="conductor_d" value="{{ $selectedCoil->wire->conductor_d }}">
                                    <input class="full-d" type="text" id="full_d" name="full_d" value="{{ $selectedCoil->wire->full_d }}">
                                </div>
                            </div>
                            <div class="">
                                <!-- Material -->
                                <div class="mb-05rem">
                                    <h2 class="h2">Material</h2>
                                    <select id="material" name="material_id">
                                        @for($i = 0; $i < count($materialList); $i++)
                                            <option value="{{ $materialList[$i]->id }}" @if($materialList[$i]->id == $selectedCoil->wire->material->id) selected @endif>{{ $materialList[$i]->name }}</option>
                                        @endfor
                                    </select>
                                    <a class="btn" href="javascript:delMaterial()">Delete</a>
                                </div>
                                <div class="form-el">
                                    <label class="w-6rem" for="density">Density</label><input class="w-5rem" type="text" id="density" name="density" value="{{ $selectedCoil->wire->material->density }}">
                                </div>
                                <div class="form-el">
                                    <label class="w-6rem" for="resistivity">Resistivity</label><input class="w-5rem" type="text" id="resistivity" name="resistivity" value="{{ $selectedCoil->wire->material->resistivity }}">
                                </div>
                                <div class="form-el">
                                    <label class="w-6rem" for="alphaT">&alpha;</label><input class="w-5rem" type="text" id="alphaT" name="alphaT" value="{{ $selectedCoil->wire->material->alphaT }}">
                                </div>
                            </div>
                        </div>
                        <div class="block__item">
                            <!-- Operation mode -->
                            <h2 class="h2">Operation mode</h2>
                            <div class="form-el">
                                <label class="w-2rem" for="I">I</label><input class="w-5rem" type="text" id="I" name="I" value="0.08">
                            </div>
                            <div class="form-el">
                                <label class="w-2rem" for="t0">T<sub>0</sub></label><input class="w-5rem" type="text" id="t0" name="t0" value="20">
                            </div>
                        </div>
                    </div>
            </section>
        <!-- </form> -->

        <section class="container p-1rem bb mb-1rem">
            <!-- Calculation -->
            <h2 class="h2">Calculation</h2>
            <div class="mb-05rem">
                <a href="javascript:calculateCoil()" class="btn">Calculate</a>
            </div>

            <table class="tbl">
                <thead>
                    <tr>
                        <th>Parameter</th>
                        <th>Value</th>
                        <th>Units</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Loop count (N)</td>
                        <td id="N"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Fill factor (&lambda;)</td>
                        <td id="lambda"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Geometry factor (G)</td>
                        <td id="G"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Wire length (l)</td>
                        <td id="L"></td>
                        <td>[m]</td>
                    </tr>
                    <tr>
                        <td>Wire mass (m)</td>
                        <td id="m"></td>
                        <td>[kg]</td>
                    </tr>
                    <tr>
                        <td>Wire resistance (R)</td>
                        <td id="R"></td>
                        <td>[&Omega;]</td>
                    </tr>
                    <tr>
                        <td>Temperature (T)</td>
                        <td id="T"></td>
                        <td>[&deg;C]</td>
                    </tr>
                    <tr>
                        <td>Current (I)</td>
                        <td id="II"></td>
                        <td>[A]</td>
                    </tr>
                    <tr>
                        <td>Voltage (V)</td>
                        <td id="V"></td>
                        <td>[V]</td>
                    </tr>
                    <tr>
                        <td>Power (W)</td>
                        <td id="W"></td>
                        <td>[W]</td>
                    </tr>
                    <tr>
                        <td>Magnetic field (B)</td>
                        <td id="B"></td>
                        <td>[mT]</td>
                    </tr>
                    <tr>
                        <td>Inductance (L)</td>
                        <td id="Li"></td>
                        <td>[mH]</td>
                    </tr>
                </tbody>
            </table>
        </section>

        <section class="container p-1rem bb mb-1rem">
            <!-- B & W charts at constant T -->
            <h2 class="h2">Charts: B, W @ T = constant</h2>

            <!--<form id="chartBW" name="chartBW" method="post" action="{{ route('pdf') }}">-->
                <div class="form-el">
                    <div class="form-el__item">
                        <label class="mr-05rem" for="startI">I<sub>0</sub></label><input class="w-5rem mr-1rem" type="text" id="startI" name="startI" value="0.01">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="stepI">Step</label><input class="w-5rem mr-1rem" type="text" id="stepI" name="stepI" value="0.01">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="endI">I</label><input class="w-5rem mr-1rem" type="text" id="endI" name="endI" value="0.1">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="TI">T</label><input class="w-5rem" type="text" id="TI" name="TI" value="20">
                    </div>
                </div>
            <!--</form>-->

            <div class="mb-05rem">
                <a href="javascript:calculateCoil()" class="btn">Calculate</a>
            </div>

            <div class="block block--jc-center">
                <div class="chart mr-1rem">
                    <canvas id="chartB"></canvas>
                </div>
                <div class="chart">
                    <canvas id="chartW"></canvas>
                </div>
            </div>
        </section>

        <section class="container p-1rem bb mb-1rem">
            <!-- R & V charts at constant I -->
            <h2 class="h2">Charts: R, V @ I = constant</h2>

            <!--<form id="chartRV">-->
                <div class="form-el">
                    <div class="form-el__item">
                        <label class="mr-05rem" for="startT">T<sub>0</sub></label><input class="w-5rem mr-1rem" type="text" id="startT" name="startT" value="20">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="stepT">Step</label><input class="w-5rem mr-1rem" type="text" id="stepT" name="stepT" value="1">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="endT">T</label><input class="w-5rem mr-1rem" type="text" id="endT" name="endT" value="160">
                    </div>
                    <div class="form-el__item">
                        <label class="mr-05rem" for="IT">I</label><input class="w-5rem" type="text" id="IT" name="IT" value="0.08">
                    </div>
                </div>
            <!--</form>-->

            <div class="mb-05rem">
                <a href="javascript:calculateCoil()" class="btn">Calculate</a>
            </div>

            <div class="block block--jc-center">
                <div class="chart mr-1rem">
                    <canvas id="chartR"></canvas>
                </div>
                <div class="chart">
                    <canvas id="chartV"></canvas>
                </div>
            </div>

        </section>
        </form>
    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/build_chart.js')}}" type="application/javascript"></script>
    <script src="{{asset('js/home.js')}}" type="application/javascript"></script>
@endpush
