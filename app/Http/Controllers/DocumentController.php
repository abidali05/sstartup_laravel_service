<?php

namespace App\Http\Controllers;

use App\Services\DocumentService;
use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentRequest;

class DocumentController extends Controller
{
    private $_service = null;
    private $_directory = 'auth/pages/document';
    private $_route = 'document';

    public function __construct()
    {
        $this->_service = new DocumentService();
    }

    public function index()
    {
        $data['all'] = $this->_service->index();
        return view($this->_directory . '.index', compact('data'));
    }

    public function create()
    {
        return view($this->_directory . '.create');
    }


    public function store(DocumentRequest $request)

    {
        try {
            $this->_service->store($request->validated());
            return redirect()->route($this->_route . '.index')->with('success', 'Document is uploaded successfully!');

        } catch (\Throwable $th) {
            return redirect()->route($this->_route . '.index')->with('error', 'Something went wrong.');
        }
    }


    public function show($id)
    {
        $data = $this->_service->show($id);
        return view($this->_directory . '.show', compact('data'));
    }


    public function edit($id)
    {
        $data = $this->_service->edit($id);
        return view($this->_directory . '.edit', compact('data'));
    }


    public function update(DocumentRequest $request, $id)
    {
        try {
            $this->_service->update($id, $request->validated());
            return redirect()->route($this->_route . '.index')->with('success', 'Document is updated successfully.');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route($this->_route . '.index')->with('error', 'Something went wrong.');
        }
    }


    public function destroy($id)
    {
        $this->_service->destroy($id);
        return redirect()->route($this->_route . '.index');
    }
}
