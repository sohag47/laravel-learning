<?php

namespace App\Http\Controllers;

use App\Enums\ApiResponseEnum;
use App\Models\Document;
use App\Services\FileUploadService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class DocumentController extends Controller
{
    use ApiResponse;
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
            return $this->respondValidationError($validator->errors());
        }

        $data = $this->fileUploadService->uploadFile($request);
        return $this->respondWithItem($data);
        
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
            return $this->respondValidationError($validator->errors());
        }

        try{
            $data = $this->fileUploadService->deleteFile($request->file_path);
            $message = ApiResponseEnum::DELETED->errorMessage();
            return $this->respondWithSuccess($data, $message);
        }catch(\Exception $error){
            return $this->respondValidationError($error->getMessage());
        }

        
    }
}
