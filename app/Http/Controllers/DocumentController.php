<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Services\FileUploadService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class DocumentController extends Controller
{
    private $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
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
        // for insert item
        $rules = [
            'field_name' => 'required',
            'path_prefix' => 'required',
            'files' => ['required', File::types(['jpg', 'png', 'pdf'])->max('5mb')],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $resource = [
                'errors'    => $validator->errors(),
                'message'   => "Validation Error",
                'success'   => false,
            ];
            return response()->json($resource, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $data = $this->fileUploadService->uploadFile($request);
            $resource = [
                'message'   => "File Upload Successfully",
                'data'      => $data,
                'success'   => true,
                'errors'    => null,
            ];
        return response()->json($resource, Response::HTTP_OK);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $rules = [
            'file_path' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $resource = [
                'errors'    => $validator->errors(),
                'message'   => "Validation Error",
                'success'   => false,
            ];
            return response()->json($resource, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        try{
            $message = $this->fileUploadService->deleteFile($request->file_path);
            $resource = [
                'message'   => $message,
                'data'      => null,
                'success'   => true,
                'errors'    => null,
            ];
            return response()->json($resource, Response::HTTP_OK);
        }catch(\Exception $error){
            $resource = [
                'errors'    => $error->getMessage(),
                'message'   => $error->getMessage(),
                'code'      => Response::HTTP_UNPROCESSABLE_ENTITY,
                'success'   => false,
            ];
            return response()->json($resource, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        
    }
}
