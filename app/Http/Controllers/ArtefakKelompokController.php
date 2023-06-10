<?php

namespace App\Http\Controllers;

use App\Models\KelompokArtefak;
use App\Models\SubmissionArtefak;
use App\Models\Kelompok;
use App\Models\Krs;
use App\Models\image_profile_temporary;
use Storage;
use Validator;
use Illuminate\Http\Request;

class ArtefakKelompokController extends Controller
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
    public function store(Request $request, Kelompok $kelompok, SubmissionArtefak $submission)
    {
        $data = [
            'file' => 'required',
        ];
        
        $validator = $request->validate($data);
        // return $request->file;

        $temporaryImages = image_profile_temporary::where('folder',$request->file);
        // if ($validator->fails()) {
        //     foreach ($temporaryImages as $temporaryImage) {
        //         Storage::deleteDirectory('artefaks/tmp'.$temporaryImage->folder);
        //         $temporaryImage->delete();
        //     }
        //     return redirect('/')->withErrors($validator)->withInput();
        // }

        // return $temporaryImages->get();
        foreach ($temporaryImages->get() as $temporaryImage){
            // return $temporaryImage->;
            Storage::copy('artefaks/tmp/'.$temporaryImage->folder.'/'.$temporaryImage->img, 'artefaks/'.$temporaryImage->folder.'/'.$temporaryImage->img);
            // KelompokArtefak::create($validator->validated());
            KelompokArtefak::create([
                'submission_id' => $submission->id,
                'kelompoks_id' => $kelompok->id,
                'file' => $temporaryImage->img,
                'folder' => $temporaryImage->folder,
            ]);

            Storage::deleteDirectory('artefaks/tmp/'.$temporaryImage->folder);
            $temporaryImage->delete();

            
        }
        return back()->with('success', 'File anda telah berhasil diupload');



    }

    /**
     * Display the specified resource.
     */
    public function show(KelompokArtefak $kelompokArtefak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KelompokArtefak $kelompokArtefak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KelompokArtefak $kelompokArtefak)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request, Kelompok $kelompok, SubmissionArtefak $submission, KelompokArtefak $artefak)
    {
        // return 'artefaks/'.$request->folder;
        Storage::deleteDirectory('artefaks/'.$request->folder);
        KelompokArtefak::find($artefak->id)->delete();

        return back()->with('success', 'Submission anda telah berhasil dihapus');
    }
}
