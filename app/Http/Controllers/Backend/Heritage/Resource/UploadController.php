<?php

namespace App\Http\Controllers\Backend\Heritage\Resource;

use App\Http\Controllers\Controller;
use App\Photos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Str;

class UploadController extends Controller
{
    public function uploadImage(Request $request, $component_id)
    {
        $photos = [];
        foreach ($request->photos as $i => $photo) {
            $originalName = $photo->getClientOriginalName();
            $ext = $photo->getClientOriginalExtension();
            $newName = Str::random(40) . '.' . $ext;

            // save image on disk
            $image = Storage::disk('public')->putFileAs('images', $photo, $newName);
            list($path, $uploadedName) = explode('/', $image);

            // save thumb on disk
            $stream = Image::make(Storage::disk('public')->get($path.'/'.$newName))->fit(300, 300)->stream();
            $thumbName = 'thumbs/'.$newName;
            $thumb = Storage::disk('public')->put($thumbName, $stream);

            $imageModel = Photos::create([
                'filename' => $image,
                'component' => $component_id,
            ]);

            $photos[$i] = [
                'id'              => $imageModel->id,
                'name'            => $originalName,
                'type'            => Storage::disk('public')->mimeType($image),
                'size'            => round(Storage::disk('public')->size($image) / 1024, 2),
                'url'             => Storage::url($image),
                'thumbnailUrl'    => Storage::url($thumbName),
                'deleteType'      => 'DELETE',
                'deleteUrl'       => '/admin/heritage/upload/' . $imageModel->id . '/delete',
            ];
        }

        return response()->json(array('files' => $photos), 200);
    }

    public function deleteImage(Request $request, $component_id, $id)
    {
        $deletePhoto = Photos::where('id', '=', $id)
            ->where('component', '=', $component_id)
            ->get()
        ;

        DB::beginTransaction();

        if ($deletePhoto instanceof Photos) {
            $image = $deletePhoto->filename;
            $imageDeleted = Storage::disk('public')->delete($image);
            $thumb = str_replace('images/', 'thumbs/', $image);
            $thumbDeleted = Storage::disk('public')->delete($thumb);

            if($deletePhoto->delete() && $imageDeleted && $thumbDeleted) {
                DB::commit();

                return response()->json([
                    $image => $imageDeleted,
                    $thumb => $thumbDeleted,
                ], 200);
            }

            return response()->json([
                $image => $imageDeleted,
                $thumb => $thumbDeleted,
            ], 400);

            DB::rollBack();
        }
    }
}
