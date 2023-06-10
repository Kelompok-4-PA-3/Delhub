<?php

namespace App\Http\Controllers;

use App\Models\image_profile_temporary;
use Illuminate\Http\Request;
use Storage;

class ArtefakTemporaryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->file('file')) {
                $image = $request->file('file');
                $fileName = $image->getClientOriginalName();
                $folder = uniqid('artefak-', true);
                $image->storeAs('artefaks/tmp/'.$folder, $fileName);
    
                image_profile_temporary::create([
                    'folder' => $folder,
                    'img' => $fileName,
                    'deskripsi' => '-',
                ]);
    
                return $folder;
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
       

        return '';
    }

    /**
     * Display the specified resource.
     */
    public function show(image_profile_temporary $image_profile_temporary)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(image_profile_temporary $image_profile_temporary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, image_profile_temporary $image_profile_temporary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        $temporary_image = image_profile_temporary::where('folder',request()->getContent())->first();
        if ($temporary_image) {
            Storage::deleteDirectory('artefaks/tmp/'.$temporary_image->folder);
            $temporary_image->delete();
        }

        return response()->noContent();
    }
}
