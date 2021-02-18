<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\NavigateClass;

class InputOutputDataApi extends ApiController
{
    /**
     * @Route("application/api/v1/du-lieu-input-output/", name="iodata.index")
     */
    public function index(Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $conditions = [];
            $projectInformationList = $projectManagementBusiness->getProjectInformations($conditions);
            $this->dataResponse['projectInformationList'] = $projectInformationList;

            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/du-lieu-input-output", name="iodata.create")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/du-lieu-input-output/", name="iodata.store")
     */
    public function store(Request $request)
    {
        try{
            $inputOutputDataBusiness = new \App\Business\InputOutputDataBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            
            switch($data['name']){
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_INPUT: 
                    $this->error = $inputOutputDataBusiness->validateInputData($data);
                    if(empty($this->error)){
                        $data = $inputOutputDataBusiness->createInputData($data);
                        $this->dataResponse['data'] = $data;
                        $this->message = $inputOutputDataBusiness->messageInputDataSuccessful($data);
                    }
                    break;
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_OUTPUT:
                    $this->error = $inputOutputDataBusiness->validateOutputData($data);
                    if(empty($this->error)){
                        $data = $inputOutputDataBusiness->createOutputData($data);
                        $this->dataResponse['data'] = $data;
                        $this->message = $inputOutputDataBusiness->messageOutputDataSuccessful($data);
                    }
                    // send notification
                    break;
                default: 
                throw new \Exception();
            }
            
            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_CREATED);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("application/api/v1/du-lieu-input-output/", name="iodata.store")
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
     * @Route("application/api/v1/du-lieu-input-output/{id}", name="iodata.store")
     */
    public function update($id, Request $request)
    {
        try{
            $inputOutputDataBusiness = new \App\Business\InputOutputDataBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            switch($data['name']){
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_INPUT: 
                    $this->error = $inputOutputDataBusiness->validateInputData($data);
                    if(empty($this->error)){
                        $data = $inputOutputDataBusiness->updateInputData($data, $id);
                        $this->dataResponse['data'] = $data;
                        $this->message = $inputOutputDataBusiness->messageInputDataSuccessful($data);
                    }
                    // send notification
                    break;
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_OUTPUT:
                    $this->error = $inputOutputDataBusiness->validateOutputData($data);
                    if(empty($this->error)){
                        $data = $inputOutputDataBusiness->updateOutputData($data, $id);
                        $this->dataResponse['data'] = $data;
                        $this->message = $inputOutputDataBusiness->messageOutputDataSuccessful($data);
                    }
                    // send notification
                    break;
                default: 
                throw new \Exception();
            }
            
            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_CREATED);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/du-lieu-input-output/{id}", name="iodata.delete")
     */
    public function destroy($id, Request $request)
    {
        try{
            $inputOutputDataBusiness = new \App\Business\InputOutputDataBusiness($this->actor, $this->timeRequest);
            $name = $request->input('name');
            switch($name){
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_INPUT: 
                    $result = $inputOutputDataBusiness->deleteInputData($id);
                    if(is_bool($result)){
                        $this->dataResponse['data'] = $result;
                        // send notification
                    }else{
                        $this->error = $result;
                    }
                    // send notification
                    break;
                case \App\Constants\DropdownLabel::IO_DATA_TYPE_OUTPUT:
                    $result = $inputOutputDataBusiness->deleteOutputData($id);
                    if(is_bool($result)){
                        $this->dataResponse['data'] = $result;
                        // send notification
                    }else{
                        $this->error = $result;
                    }
                    // send notification
                    break;
                default: 
                throw new \Exception();
            }
            
            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_NO_CONTENT);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/du-lieu-input-output/load-data", name="iodata.loaddata")
     */
    public function loadData(Request $request)
    {
        try{
            $projectId = $request->input('projectId');
            $inputOutputDataBusiness = new \App\Business\InputOutputDataBusiness($this->actor, $this->timeRequest);
            $conditions = [];
            $data = $inputOutputDataBusiness->getLoadData($projectId);
            $this->dataResponse['data'] = $data;

            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        }catch(\Exception $e){

            return response()->json([
                'data' => '',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
