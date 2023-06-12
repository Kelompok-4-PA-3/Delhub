<?php

namespace App\Http\Controllers;

use App\Models\TemplateDocument;
use App\Models\Krs;
use Storage;
use Illuminate\Http\Request;

class TemplateDocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Krs $kr)
    {
        $document = TemplateDocument::where('krs_id', $kr->id)->get();
        // return $kr;
        return view('dashboard.template.index', [
            'krs' => $kr,
            'document' => $document
        ]);
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
    public function store(Request $request, Krs $kr)
    {
        $data = [
            'deskripsi' => 'required',
            'file_template' => 'required',
        ];

        $validasi = $request->validate($data);

        $file = '';
        if ($request->file('file_template')) {
            $filename = $request->file('file_template')->getClientOriginalName();
            $path = $request->file('file_template')->storeAs('public/file-template/', $filename);
            $file =  $filename;
        }

        TemplateDocument::create([
            'krs_id' => $kr->id,
            'deskripsi' => $validasi['deskripsi'],
            'file_template' => $file,
        ]);

        return back()->with('success', 'Template document telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TemplateDocument $templateDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Krs $kr, TemplateDocument $templateDocument)
    {
        // $data = [
        //     'deskripsi' => 'required',
        //     'file_template' => 'nullable',
        // ];


        // $file = '';
        // if ($request->file('file_template')) {
        //     $data['file_template'] = 'required';

        //     $filename = $request->file('file_template')->getClientOriginalName();
        //     $path = $request->file('file_template')->storeAs('public/file-template/', $filename);
        //     $file =  $filename;
        // }
        // $validasi = $request->validate($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $kr, TemplateDocument $document)
    {
        // return $request->file('file_template');
        $data = [
            'deskripsi' => 'required',
            'file_template' => 'nullable',
        ];

        $template = TemplateDocument::find($document->id);

        if ($request->file('file_template')) {
            $path = 'public/file-template/' . $request->old_file;
            if (Storage::disk('public')->exists($path)) {
                Storage::delete($path);
            } else {
                return back()->with('error', 'File tidak ditemukan');
            }

            $filename = $request->file('file_template')->getClientOriginalName();
            $path = $request->file('file_template')->storeAs('public/file-template/', $filename);
            $template->file_template =  $filename;
        }

        $validasi = $request->validate($data);
        $template->deskripsi = $validasi['deskripsi'];
        $template->save();

        return back()->with('success', 'Template document telah berhasil diedit');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Krs $kr, TemplateDocument $document)
    {
        $template = TemplateDocument::find($document->id);
        $path = 'public/file-template/' . $document->file_template;
        if (Storage::disk('public')->exists($path)) {
            Storage::delete($path);
        } else {
            return back()->with('error', 'File tidak ditemukan');
        }

        $template->delete();
        return back()->with('success', 'Template berhasil dihapus');
    }

    public function publish(Krs $kr)
    {
        $template = TemplateDocument::where('krs_id', $kr->id)->get();
        foreach ($template as $t) {
            $t->is_verified = true;
            $t->save();
        }

        return back()->with('success', 'Template berhasil diterbitkan');
    }
}
