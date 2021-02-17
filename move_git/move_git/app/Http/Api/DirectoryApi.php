<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use App\NavigateClass;
use Symfony\Component\HttpFoundation\Response;

class DirectoryApi extends ApiController
{
    /**
     * @Route("application/api/v1/file", name="file.create")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/file", name="file.store")
     */
    public function store(Request $request)
    {
        try{
            $directoryBusiness = new \App\Business\DirectoryBusiness();
            $data = $request->all();
            switch($data['type']){
                case \App\Constants\DropdownLabel::DIRECTORY_INPUT: 
                    $data = $directoryBusiness->createDirectoryForInputData($data);
                break;
                case \App\Constants\DropdownLabel::DIRECTORY_OUTPUT: 
                    $data = $directoryBusiness->createDirectoryForOutputData($data);
                break;
                default: 
                throw new \Exception();
            }
            
            $this->dataResponse['data'] = $data;

            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_CREATED);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("application/api/v1/file/", name="file.store")
     */
    public function show($id, Request $request)
    {
        try{
            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'typeInfo' => '',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("application/api/v1/file", name="file.store")
     */
    public function update($id, Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness(1, $this->timeRequest);
            $data = $request->all();
            $typeInfo = $data['type'];
            switch($typeInfo){
                case \App\Constants\ProjectManagement::TYPE_INFO_PROJECT_INFO: 
                    
                break;
                case \App\Constants\ProjectManagement::TYPE_INFO_JOINT_STAFF:
                 
                default:
                throw new \Exception();
            }
            $this->dataResponse['type'] = $typeInfo;

            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_CREATED);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy($id)
    {

    }
}
