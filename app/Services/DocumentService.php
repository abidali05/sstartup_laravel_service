<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\UploadedFile;

class DocumentService
{
    private $_model = null;


    public function __construct()
    {
        $this->_model = new Document();
    }
    public function index()

    {
        $user = Auth::user();
        $userId = Auth::user()->id;
        if ($user->hasRole('customer')) {
            return $this->_model::where('user_id', $userId)->latest()->get();
        } else {
            return $this->_model::latest()->get();
        }
    }

    public function store(array $data)

    {
        $userId = Auth::user()->id;

        $document = new $this->_model;
        $document->user_id = $userId;
        $document->title = $data['title'];
        if (isset($data['document_file'])) {
            $documentFile = $data['document_file'];
            $filename = uniqid() . '_' . $documentFile->getClientOriginalName();
            $documentFile->move(public_path('uploads'), $filename);
            $document->document_file = 'uploads/' . $filename;
        }

        $document->save();
    }

    public function edit($id)

    {
        return $this->_model::find($id);
    }

    public function update($id, array $data)
    {
        $document = $this->_model->findOrFail($id);

        $document->title = $data['title'];
        if ($data['document_file'] instanceof UploadedFile) {
            $filename = uniqid() . '_' . $data['document_file']->getClientOriginalName();
            $data['document_file']->move(public_path('uploads'), $filename);
            $document->document_file = 'uploads/' . $filename;
        }

        $document->status = $data['status'];
        $document->save();
    }

    public function show($id)

    {
        return $this->_model::find($id);
    }
}
