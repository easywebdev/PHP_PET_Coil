<?php


namespace App\Http\Controllers;


use App\Models\Wire;
use Illuminate\Http\Request;

class WireController extends Controller
{
    /**
     * @return Wire[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getWiresList()
    {
        return Wire::all('id', 'name');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getWire(Request $request)
    {
        $wire = Wire::find($request->input('id'));
        $wire->material;

        return $wire;
    }

    /**
     * @param string $name
     * @param float $conductor_d
     * @param float $full_d
     * @param int $materials_id
     * @return int
     */
    public function addWire(string $name, float $conductor_d, float $full_d, int $materials_id) : int
    {
        $wire = new Wire();

        $wire->name = $name;
        $wire->conductor_d = $conductor_d;
        $wire->full_d = $full_d;
        $wire->materials_id = $materials_id;

        $wire->save();

        return $wire->id;
    }

    /**
     * @param array $wireData
     * @return string
     */
    public function putWire(array $wireData)
    {
        $wire = Wire::find($wireData['id']);
        $default = ['Cu-0.1', 'Cu-0.26', 'Al-0.26'];

        if(!in_array($wire->name, $default)) {
            $wire->conductor_d = $wireData['conductor_d'];
            $wire->full_d = $wireData['full_d'];
            $wire->materials_id = $wireData['materials_id'];
            $wire->save();

            return " The wire $wire->name had been  updated";
        }
        else {
            return "You cannot update default coil $wire->name";
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function delWire(int $id) : string
    {
        $msg = 'Wire deleting error';
        $default = ['Cu-0.1', 'Cu-0.26', 'Al-0.26'];
        $wire = Wire::find($id);

        if($wire) {
            // check default wire
            if(in_array($wire->name, $default)) {
                $msg = 'You cannot delete default wire "' . $wire->name . '"';
                return $msg;
            }

            // check coils woth this design
            $coils = $wire->coils;
            if(count($coils) > 0) {
                $msg = 'This wire is used by next coils: ';
                foreach ($coils as $coil) {
                    $msg = $msg . $coil->name . ' ';
                }
                $msg = $msg . '. You have to select another wires for this coils first.';
            }
            else {
                //del design
                $wire->delete();
                $msg = 'The wire "' . $wire->name . '" had been deleted';
            }
        }

        return $msg;
    }
}
