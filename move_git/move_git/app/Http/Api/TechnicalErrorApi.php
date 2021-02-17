<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TechnicalErrorApi extends ApiController
{
    /**
     * @Route("application/api/v1/loi-ky-thuat/")
     */
    public function index(Request $request)
    {
        try {
            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json([
                'data' => '',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/loi-ky-thuat")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/loi-ky-thuat/")
     */
    public function store(Request $request)
    {
        try{
            $technicalErrorBusiness = new \App\Business\TechnicalErrorBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $this->dataResponse['data'] = $technicalErrorBusiness->addTechnicalErrorList($data['technicalErrorList']);

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
     * @Route("application/api/v1/loi-ky-thuat/{id}")
     */
    public function show($id, Request $request)
    {
        try {
            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'typeInfo' => '',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("application/api/v1/loi-ky-thuat/{id}")
     */
    public function update($id, Request $request)
    {
        try{
            $technicalErrorBusiness = new \App\Business\TechnicalErrorBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $technicalErrorObj = $technicalErrorBusiness->updateTechnicalError($data, $id);
            $this->dataResponse['data'] = $technicalErrorObj;

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
     * @Route("application/api/v1/loi-ky-thuat/{id}")
     */
    public function destroy($id, Request $request)
    {
        try {
            $technicalErrorBusiness = new \App\Business\TechnicalErrorBusiness($this->actor, $this->timeRequest);
            $result = $technicalErrorBusiness->deleteTechnicalError($id);
            if(is_bool($result)){
                $this->dataResponse['data'] = $result;
                // send notification
            }else{
                $this->error = $result;
            }
            
            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

     /**
     * @Route("application/api/v1/loi-ky-thuat/export/{projectId}", name="technical.error.export")
     */
    public function exportTechnicalError($projectId, Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $projectInfoObj = $projectManagementBusiness->getProjectInformationById($projectId); 
            $projectCode = $projectInfoObj->project_id;
            $technicalErrorBusiness = new \App\Business\TechnicalErrorBusiness($this->actor, $this->timeRequest);
            $pathToFile = $technicalErrorBusiness->exportTechnicalError($projectId);
            $fileName = "LOI KY THUAT $projectCode.xlsx";
            $headers = [
                'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
                'Content-Disposition' => "attachment; filename=$fileName",
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Cache-Control' => 'private',
            ];
            
            return response()->download($pathToFile, $fileName, $headers);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
}
