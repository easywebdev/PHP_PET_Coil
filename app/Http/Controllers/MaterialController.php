<?php


namespace App\Http\Controllers;


use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * @return Material[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getMaterialsList()
    {
        return Material::all('id', 'name');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getMaterial(Request $request)
    {
        return Material::find($request->input('id'));
    }

    /**
     * @param float $density
     * @param float $resistivity
     * @param float $alphaT
     * @return int
     */
    public function addMaterial(string $name, float $density, float $resistivity, float $alphaT) : int
    {
        $material = new Material();

        $material->name = $name;
        $material->density = $density;
        $material->resistivity = $resistivity;
        $material->alphaT = $alphaT;

        $material->save();

        return $material->id;
    }

    /**
     * @param array $materialData
     * @return string
     */
    public function putMaterial(array $materialData) : string
    {
        $material = Material::find($materialData['id']);
        $default = ['Cu', 'Al'];

        if(!in_array($material->name, $default)) {
            $material->density = $materialData['density'];
            $material->resistivity = $materialData['resistivity'];
            $material->alphaT = $materialData['alphaT'];
            $material->save();

            return "The material $material->name had been updated";
        }
        else{
            return "You cannot update the default material $material->name";
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function delMaterial(int $id) : string
    {
        $msg = 'Material deleting error';
        $default = ['Cu', 'Al'];
        $material = Material::find($id);

        if($material) {
            // check default material
            if(in_array($material->name, $default)) {
                $msg = 'You cannot delete default material "' . $material->name . '"';
                return $msg;
            }

            // check coils woth this design
            $wires = $material->wires;
            if(count($wires) > 0) {
                $msg = 'This material is used by next wires: ';
                foreach ($wires as $wire) {
                    $msg = $msg . $wire->name . ' ';
                }
                $msg = $msg . '. You have to select another materials for this wires first.';
            }
            else {
                //del design
                $material->delete();
                $msg = 'Material "' . $material->name . '" had been deleted';
            }
        }

        return $msg;
    }
}