<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Photos;
use Folklore\Image\Facades\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function uploadSubmit(Request $request)
    {
        $photos = [];
        foreach ($request->photos as $i => $photo) {
            $path = storage_path('app/public/');
            $subpath = 'photos/';
            $filenamePath = $photo->store($subpath, ['disk' => 'public']);
            $product_photo = Photos::create([
                'filename' => str_replace($subpath . '/', '', $filenamePath)
            ]);
            $thumbfile = Image::make($path.$filenamePath, ['width' => 300, 'height' => 300])
                ->save($path.'thumbs/'.str_replace($subpath . '/', '', $filenamePath));

            $photos[$i] = [
                'id'              => $product_photo->id,
                'name'            => str_replace($subpath . '/', '', $photo->getClientOriginalName()), // send back the original name ;)
                'type'            => Storage::disk('public')->mimeType($filenamePath),
                'size'            => round(Storage::disk('public')->size($filenamePath) / 1024, 2),
                'url'             => Image::url($filenamePath),
                'thumbnailUrl'    => Image::url('thumbs/'.str_replace($subpath . '/', '', $filenamePath), 300, 300),
                'deleteType'      => 'DELETE',
                'deleteUrl'       => '/admin/heritage/upload/' . $product_photo->id . '/delete',
            ];
        }

        return response()->json(array('files' => $photos), 200);
    }
}
