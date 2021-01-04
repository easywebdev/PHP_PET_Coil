<?php


namespace App\Actions;


class ValidRules
{
    /**
     * @var string[]
     */
    public static $calculateRules = [
        'inner_d'          => 'required|numeric',
        'outer_d'          => 'required|numeric',
        'length'           => 'required|numeric',
        'conductor_d'      => 'required|numeric',
        'full_d'           => 'required|numeric',
        'density'          => 'required|numeric',
        'resistivity'      => 'required|numeric',
        'alphaT'           => 'required|numeric',
        'I'                => 'required|numeric',
        't0'               => 'required|numeric',
        'startI'           => 'required|numeric',
        'stepI'            => 'required|numeric|lte:endI',
        'endI'             => 'required|numeric',
        'TI'               => 'required|numeric',
        'startT'           => 'required|numeric',
        'stepT'            => 'required|numeric|lte:endT',
        'endT'             => 'required|numeric',
        'IT'               => 'required|numeric',
    ];

    /**
     * @var string[]
     */
    public static $updateRules = [
        'inner_d'          => 'required|numeric',
        'outer_d'          => 'required|numeric',
        'length'           => 'required|numeric',
        'conductor_d'      => 'required|numeric',
        'full_d'           => 'required|numeric',
        'density'          => 'required|numeric',
        'resistivity'      => 'required|numeric',
        'alphaT'           => 'required|numeric',
    ];

    /**
     * @var string[]
     */
    public static $saveRules = [
        'coil.name'            => 'required|unique:coil_coils,name',
        'design.name'          => 'required|unique:coil_designs,name,',
        'design.inner_d'       => 'required|numeric',
        'design.outer_d'       => 'required|numeric',
        'design.length'        => 'required|numeric',
        'wire.name'            => 'required|unique:coil_wires,name',
        'wire.conductor_d'     => 'required|numeric',
        'wire.full_d'          => 'required|numeric',
        'material.name'        => 'required|unique:coil_materials,name',
        'material.density'     => 'required|numeric',
        'material.resistivity' => 'required|numeric',
        'material.alphaT'      => 'required|numeric',
    ];
}