<?php


namespace App\Http\Controllers;


use App\Models\Design;
use Illuminate\Http\Request;

class DesignController extends Controller
{
    /**
     * @return Design[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getDesignsList()
    {
        return Design::all('id', 'name');
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getDesign(Request $request)
    {
        return Design::find($request->input('id'));
    }

    /**
     * @param string $name
     * @param float $inner_d
     * @param float $outer_d
     * @param float $length
     * @return int
     */
    public function addDesign(string $name, float $inner_d, float $outer_d, float $length) : int
    {
        $design = new Design();

        $design->name = $name;
        $design->inner_d = $inner_d;
        $design->outer_d = $outer_d;
        $design->length = $length;

        $design->save();

        return $design->id;
    }

    /**
     * @param array $designData
     * @return string
     */
    public function putDesign(array $designData) : string
    {
        $design = Design::find($designData['id']);
        $default = ['D-10-12', 'D-19-30'];

        if(!in_array($design->name, $default)) {
            $design->outer_d = $designData['outer_d'];
            $design->inner_d = $designData['inner_d'];
            $design->length = $designData['length'];
            $design->save();

            return "The design $design->name had been updated";
        }
        else {
            return "You cannot update default design $design->name";
        }
    }

    /**
     * @param int $id
     * @return string
     */
    public function delDesign(int $id) : string
    {
        $msg = 'Design deleting error';
        $default = ['D-10-12', 'D-19-30'];
        $design = Design::find($id);

        if($design) {
            if(!in_array($design->name, $default)) {
                // check coils with this design
                $coils = $design->coils;
                if(count($coils) > 0) {
                    $msg = 'This design is used by next coils: ';
                    foreach ($coils as $coil) {
                        $msg = $msg . $coil->name . ' ';
                    }
                    $msg = $msg . '. You have to select another design for this coils first.';
                }
                else {
                    //del design
                    $design->delete();
                    $msg = 'Design "' . $design->name . '" had been deleted';
                }
            }
            else {
                $msg = 'You cannot delete default design "' . $design->name . '"';
            }
        }

        return $msg;
    }
}