@extends('layout')

@section('content')
    <main class="s-main">
        <div class=" container mb-1rem">
            <a class="btn" href="{{ url()->previous() }}">Back</a>
            <a class="btn" href="javascript:saveCoil()">Save</a>
        </div>
        <section class="coil container p-1rem bb mb-1rem">
            <h2 class="h2">Coil</h2>
            <form id="coil" action="">
                @csrf
                <div>
                    <label for="coilName">Coil name</label><input type="text" name="name">
                </div>
            </form>
        </section>

        <section class="container p-1rem bb mb-1rem">
            <div class="block">
                <div class="block__item mr-1rem">
                    <!-- Design -->
                    <h2 class="h2">Design</h2>
                    <form id="design" action="">
                        <div class="mb-05rem">
                            <select id="designID" name="id">
                                @for($i = 0; $i < count($designList); $i++)
                                    <option value="{{ $designList[$i]->id }}" >{{ $designList[$i]->name }}</option>
                                @endfor
                                <option value="{{ null }}" selected>New design</option>
                            </select>
                            <label for="designName">Name</label><input id="designName" type="text" name="name" value="">
                        </div>
                        <div class="design">
                            <input class="inner-d" type="text" id="inner_d" name="inner_d" value="">
                            <input class="outer-d" type="text" id="outer_d" name="outer_d" value="">
                            <input class="length" type="text" id="length" name="length" value="">
                        </div>
                    </form>
                </div>

                <div class="block__item mr-1rem">
                    <div class="mb-1rem">
                        <!-- Wire -->
                        <h2 class="h2">Wire</h2>
                        <form id="wire" action="">
                            <div class="mb-05rem">
                                <select id="wireID" name="id">
                                    @for($i = 0; $i < count($wireList); $i++)
                                        <option value="{{ $wireList[$i]->id }}">{{ $wireList[$i]->name }}</option>
                                    @endfor
                                    <option value="{{ null }}" selected>New wire</option>
                                </select>
                                <label for="wireName">Name</label><input id="wireName" type="text" name="name" value="">
                            </div>
                            <div class="wire">
                                <input class="conductor-d" type="text" id="conductor_d" name="conductor_d" value="">
                                <input class="full-d" type="text" id="full_d" name="full_d" value="">
                            </div>
                        </form>
                    </div>

                    <div class="">
                        <!-- Material -->
                        <h2 class="h2">Material</h2>
                        <form id="material" action="">
                            <div class="mb-05rem">
                                <select id="materialID" name="id">
                                    @for($i = 0; $i < count($materialList); $i++)
                                        <option value="{{ $materialList[$i]->id }}">{{ $materialList[$i]->name }}</option>
                                    @endfor
                                    <option value="{{ null }}" selected>New material</option>
                                </select>
                                <label for="materialName">Name</label><input id="materialName" type="text" name="name" value="">
                            </div>
                            <div class="form-el">
                                <label class="w-6rem" for="density">Density</label><input class="w-5rem" type="text" id="density" name="density" value="">
                            </div>
                            <div class="form-el">
                                <label class="w-6rem" for="resistivity">Resistivity</label><input class="w-5rem" type="text" id="resistivity" name="resistivity" value="">
                            </div>
                            <div class="form-el">
                                <label class="w-6rem" for="alphaT">&alpha;</label><input class="w-5rem" type="text" id="alphaT" name="alphaT" value="">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('scripts')
    <script src="{{asset('js/newcoil.js')}}" type="application/javascript"></script>
@endpush
