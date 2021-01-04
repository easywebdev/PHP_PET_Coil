<?php


namespace App\Http\Controllers;


use App\Models\Coil;

class CoilController extends Controller
{
    /**
     * @return Coil[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCoils()
    {
        return Coil::all();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getCoil(int $id)
    {
        $coil = Coil::find($id);

        if($coil) {
            $coil->design;
            $coil->wire->material;
            return $coil;
        }
        else {
            return null;
        }


    }

    /**
     * @return mixed
     */
    public function getCoilFirst()
    {
        $coil = Coil::first();
        $coil->design;
        $coil->wire->material;

        return $coil;
    }

    /**
     * @param string $name
     * @param int $designID
     * @param int $wireID
     * @return int
     */
    public function addCoil(string $name, int $designID, int $wireID) : int
    {
        $coil = new Coil();

        $coil->name = $name;
        $coil->designs_id = $designID;
        $coil->wires_id = $wireID;

        $coil->save();

        return $coil->id;
    }

    /**
     * @param int $coilID
     * @param int $designID
     * @param int $wireID
     * @return string
     */
    public function putCoil(int $coilID, int $designID, int $wireID) : string
    {
        $coil = Coil::find($coilID);

        // Check default and save
        $default = ['H-27-58', 'H-41-85'];
        if(!in_array($coil->name, $default)) {
            $coil->designs_id = $designID;
            $coil->wires_id = $wireID;
            $coil->save();

            return "The coil $coil->name had been updated";
        }
        else {
            return "You cannot update default coil $coil->name";
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function delCoil(int $id) : string
    {
        $msg = 'Coil deleting error';
        $default = ['H-27-58', 'H-41-85'];
        $coil = Coil::find($id);

        if($coil) {
            if(!in_array($coil->name, $default)) {
                $coil->delete();
                $msg = 'The coil "' . $coil->name . '" had been deleted';
            }
            else {
                $msg = 'You cannot delete default coil "' . $coil->name . '"';
            }
        }

        return $msg;
    }
}