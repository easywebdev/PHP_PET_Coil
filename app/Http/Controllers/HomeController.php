<?php


namespace App\Http\Controllers;


use App\Actions\MyValidator;
use App\Actions\ValidMessages;
use App\Actions\ValidRules;
use Illuminate\Http\Request;
use PDF;

class HomeController extends Controller
{
    public function getCoilData(Request $request)
    {
        $coilController = new CoilController();
        $designController = new DesignController();
        $wireController = new WireController();
        $materialController = new MaterialController();

        // Get coil list
        $coilList = $coilController->getCoils();

        if(intval($request->route('id'))) {
            $selectedCoil = $coilController->getCoil($request->route('id'));
            if($selectedCoil == null) {
                return redirect('/');
            }
        }
        else {
            $selectedCoil = $coilController->getCoilFirst();
        }

        // Get designs list
        $designList = $designController->getDesignsList();

        // Get wires list
        $wireList = $wireController->getWiresList();

        // Get materials list
        $materialList = $materialController->getMaterialsList();

        return [
            'coilList'     => $coilList,
            'coilID'       => $selectedCoil->id,
            'selectedCoil' => $selectedCoil,
            'designList'   => $designList,
            'wireList'     => $wireList,
            'materialList' => $materialList,
        ];
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function getCoil(Request $request)
    {
        $coilData = $this->getCoilData($request);

        return view('home', $coilData);
    }

    public function newCoil()
    {
        $designController = new DesignController();
        $wireController = new WireController();
        $materialController = new MaterialController();

        // Get designs list
        $designList = $designController->getDesignsList();

        // Get wires list
        $wireList = $wireController->getWiresList();

        // Get materials list
        $materialList = $materialController->getMaterialsList();

        return view('newcoil', [
            'designList'   => $designList,
            'wireList'     => $wireList,
            'materialList' => $materialList,
        ]);
    }

    public function saveCoil(Request $request)
    {
        $err = null;
        $materialID = null;
        $wireID = null;
        $designID = null;

        $coilController = new CoilController();
        $designController = new DesignController();
        $wireController = new WireController();
        $materialController = new MaterialController();

        // Validate
        if($request->input('material')['id'] != null)
        {
            $materialID = $request->input('material')['id'];
            ValidRules::$saveRules['material.name'] = 'required|unique:coil_materials,name,' . $materialID;
        }

        if($request->input('wire')['id'] != null)
        {
            $wireID = $request->input('wire')['id'];
            ValidRules::$saveRules['wire.name'] = 'required|unique:coil_wires,name,' . $wireID;
        }

        if($request->input('design')['id'] != null)
        {
            $designID = $request->input('design')['id'];
            ValidRules::$saveRules['design.name'] = 'required|unique:coil_designs,name,' . $designID;
        }


        $validator = new MyValidator();
        $err = $validator->validateData($request->input(), ValidRules::$saveRules, ValidMessages::$saveMessages);

        // Save all data
        if($err == null) {
            // Save material
            if($materialID == null) {
                $materialID = $materialController->addMaterial(
                    $request->input('material')['name'],
                    $request->input('material')['density'],
                    $request->input('material')['resistivity'],
                    $request->input('material')['alphaT']
                );
            }

            // Save wire
            if($wireID == null) {
                $wireID = $wireController->addWire(
                    $request->input('wire')['name'],
                    $request->input('wire')['conductor_d'],
                    $request->input('wire')['full_d'],
                    $materialID
                );
            }

            // Save design
            if($designID == null) {
                $designID = $designController->addDesign(
                    $request->input('design')['name'],
                    $request->input('design')['inner_d'],
                    $request->input('design')['outer_d'],
                    $request->input('design')['length']
                );
            }

            // Save coil
            $coilID = $coilController->addCoil(
                $request->input('coil')['name'],
                $designID,
                $wireID
            );
        }

        return [
            'err' => $err,
            'coilID' => $coilID,
        ];
    }

    /**
     * @param Request $request
     * @return array
     */
    public function updateCoil(Request $request)
    {
        $err = null;
        $result = null;

        $coilController = new CoilController();
        $designController = new DesignController();
        $wireController = new WireController();
        $materialController = new MaterialController();

        // Validate
        $validator = new MyValidator();
        $err = $validator->validateData($request->input(), ValidRules::$updateRules, ValidMessages::$updateMessages);

        // Save
        if($err == null) {
            $result[] = $coilController->putCoil($request->input('coil_id'), $request->input('design_id'), $request->input('wire_id'));

            $designData = [
                'id' => $request->input('design_id'),
                'outer_d' => $request->input('outer_d'),
                'inner_d' => $request->input('inner_d'),
                'length' => $request->input('length'),
            ];
            $result[] = $designController->putDesign($designData);

            $wireData = [
                'id' => $request->input('wire_id'),
                'conductor_d'  => $request->input('conductor_d'),
                'full_d'       => $request->input('full_d'),
                'materials_id' => $request->input('material_id'),
            ];
            $result[] = $wireController->putWire($wireData);

            $materialData = [
                'id'          => $request->input('material_id'),
                'density'     => $request->input('density'),
                'resistivity' => $request->input('resistivity'),
                'alphaT' => $request->input('alphaT'),
            ];
            $result[] = $materialController->putMaterial($materialData);
        }

        return [
            'err'    => $err,
            'result' => $result,
        ];
    }

    public function getPDF(Request $request)
    {
        $calculator = new CalculateController();
        $calculation = $calculator->calculateCoil($request);
        //print_r($request->input());

        $coilData = $this->getCoilData($request);
        $coilData['I'] = $request->input('I');
        $coilData['t0'] = $request->input('t0');
        $coilData['result'] = $calculation['result'];
        $coilData['chartBW'] = $calculation['chartBW'];
        $coilData['chartRV'] = $calculation['chartRV'];
        $coilData['err'] = $calculation['err'];

        $pdf = PDF::loadView('pdf', $coilData);

//        $pdf->setOptions([
//            'enable-javascript' => true,
//            'javascript-delay' => 13500,
//            'enable-smart-shrinking' => true,
//            'no-stop-slow-scripts' => true,
//            'enable-css' => true,
//        ]);

        return $pdf->download('hdtuto.pdf');
    }
}