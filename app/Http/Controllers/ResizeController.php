<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class ResizeController extends Controller
{

    public function index()
    {
    	return view('welcome');
    }

    public function resizeImage(Request $request)
    {
        //Validate the image
	    $this->validate($request, [
            'file' => 'required|image|mimes:jpg,jpeg,png,gif,svg',
        ]);

        //Fetch image from request
        $image = $request->file('file');

        //Fetxh file name
        $input['file'] = time().'.'.$image->getClientOriginalExtension();

        //Set the storage for edited image
        $destinationPath = 'thumbnail';

        // Make Intervention substance
        $imgFile = Image::make($image->getRealPath());

        //Inserting frame on the center of the image
        $imgFile->insert('frame.png', 'center');

        //Saving edited image
        $imgFile->save($destinationPath."/".$input['file']);

        //Addressing new storage for the original image
        $destinationPath = public_path('/uploads');

        //Moving original image to the new pointed storage
        $image->move($destinationPath, $input['file']);

        //Giving return value with a success alert and the edited filename to be shown
        return back()
        	->with('success','Image has successfully uploaded.')
        	->with('fileName', $input['file']);
    }

}
