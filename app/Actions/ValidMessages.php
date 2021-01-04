<?php


namespace App\Actions;


class ValidMessages
{
    /**
     * @var string[]
     */
    public static $calculateMessages = [
        'inner_d.required' => 'The internal design diameter is required',
        'inner_d.numeric' => 'the internal design diameter must be a number',
        'outer_d.required' => 'The outer design diameter is required',
        'outer_d.numeric' => 'The outer design diameter must be a number',
        'length.required' => 'The design length is required',
        'length.numeric' => 'The design length must be a number',
        'conductor_d.required' => 'The wire conductor diameter is required',
        'conductor_d.numeric' => 'The wire conductor diameter must be a number',
        'full_d.required' => 'The wire isolator diameter is required',
        'full_d.numeric' => 'The wire isolator diameter must be a number',
        'density.required' => 'The wire material density is required',
        'density.numeric' => 'The wire material density must be a number',
        'resistivity.required' => 'The wire material resistivity is required',
        'resistivity.numeric' => 'The wire material resistivity must be a number',
        'alphaT.required' => 'The wire material termo coefficient is required',
        'alphaT.numeric' => 'The wire material termo coefficient must be a number',
        'I.required' => 'The control current (I) is required',
        'I.numeric' => 'The control current must be a number',
        't0.required' => 'The operating temperature (T) is required',
        't0.numeric' => 'The operating temperature (T) must be a number',
        'startI.required' => 'The start I for charts is required',
        'startI.numeric' => 'The start I for charts must be a number',
        'stepI.required' => 'The step I for charts is required',
        'stepI.numeric' => 'The step I for charts must be a number',
        'stepI.lte:endI' => 'The step I for charts must be less then end I',
        'endI.required' => 'The end I for charts is required',
        'endI.numeric' => 'The end I for charts must be a number',
        'TI.required' => 'The T for Charts: B, W @ T = constant is required',
        'TI.numeric' => 'The T for Charts: B, W @ T = constant must be a number',
        'startT.required' => 'The start T for charts is required',
        'startT.numeric' => 'The start T for charts must be a number',
        'stepT.required' => 'The step T for charts is required',
        'stepT.numeric' => 'The step T for charts must be a number',
        'stepT.lte:endI' => 'The step T for charts must be less then end T',
        'endT.required' => 'The end T for charts is required',
        'endT.numeric' => 'The end T for charts must be a number',
        'IT.required' => 'The I for Charts: R, V @ I = constant is required',
        'IT.numeric' => 'The T for Charts: R, V @ I = constant must be a number',
    ];

    public static $updateMessages = [
        'inner_d.required' => 'The internal design diameter is required',
        'inner_d.numeric' => 'the internal design diameter must be a number',
        'outer_d.required' => 'The outer design diameter is required',
        'outer_d.numeric' => 'The outer design diameter must be a number',
        'length.required' => 'The design length is required',
        'length.numeric' => 'The design length must be a number',
        'conductor_d.required' => 'The wire conductor diameter is required',
        'conductor_d.numeric' => 'The wire conductor diameter must be a number',
        'full_d.required' => 'The wire isolator diameter is required',
        'full_d.numeric' => 'The wire isolator diameter must be a number',
        'density.required' => 'The wire material density is required',
        'density.numeric' => 'The wire material density must be a number',
        'resistivity.required' => 'The wire material resistivity is required',
        'resistivity.numeric' => 'The wire material resistivity must be a number',
        'alphaT.required' => 'The wire material termo coefficient is required',
        'alphaT.numeric' => 'The wire material termo coefficient must be a number',
    ];

    /**
     * @var string[]
     */
    public static $saveMessages = [
        'coil.name.required' => 'The Coil name is required',
        'coil.name.unique' => 'The Coil name has already been taken',
        'design.name.required' => 'The Design name is required',
        'design.name.unique' => 'The Design name has already been taken',
        'design.inner_d.required' => 'The internal design diameter is required',
        'design.inner_d.numeric' => 'the internal design diameter must be a number',
        'design.outer_d.required' => 'The outer design diameter is required',
        'design.outer_d.numeric' => 'The outer design diameter must be a number',
        'design.length.required' => 'The design length is required',
        'design.length.numeric' => 'The design length must be a number',
        'wire.name.required' => 'The Wire name is required',
        'wire.name.unique' => 'The Wire name has already been taken',
        'wire.conductor_d.required' => 'The wire conductor diameter is required',
        'wire.conductor_d.numeric' => 'The wire conductor diameter must be a number',
        'wire.full_d.required' => 'The wire isolator diameter is required',
        'wire.full_d.numeric' => 'The wire isolator diameter must be a number',
        'material.name.required' => 'The Material name is required',
        'material.name.unique' => 'The Material name has already been taken',
        'material.density.required' => 'The wire material density is required',
        'material.density.numeric' => 'The wire material density must be a number',
        'material.resistivity.required' => 'The wire material resistivity is required',
        'material.resistivity.numeric' => 'The wire material resistivity must be a number',
        'material.alphaT.required' => 'The wire material termo coefficient is required',
        'material.alphaT.numeric' => 'The wire material termo coefficient must be a number',
    ];
}