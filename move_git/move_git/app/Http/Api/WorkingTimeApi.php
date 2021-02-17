<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WorkingTimeApi extends ApiController
{
    /**
     * @Route("application/api/v1/cong-viec-thuc-hien/")
     */
    public function index(Request $request)
    {
        echo 'index';
    }

    /**
     * @Route("application/api/v1/cong-viec-thuc-hien")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/cong-viec-thuc-hien/")
     */
    public function store(Request $request)
    {
        try{
            $workingTimeBusiness = new \App\Business\WorkingTimeBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $this->dataResponse['data'] = $workingTimeBusiness->addWorkingTimeList($data['workDoneList']);

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
     * @Route("application/api/v1/cong-viec-thuc-hien/{id}")
     */
    public function show($id, Request $request)
    {
        // try {
        //     return response()->json([
        //         'data' => $this->dataResponse,
        //         'error' => '',
        //     ], Response::HTTP_OK);
        // } catch (\Exception $e) {

        //     return response()->json([
        //         'data' => null,
        //         'typeInfo' => '',
        //         'error' => $e->getMessage(),
        //     ], Response::HTTP_INTERNAL_SERVER_ERROR);
        // }
    }


    /**
     * @Route("application/api/v1/cong-viec-thuc-hien/{id}")
     */
    public function update($id, Request $request)
    {
        try{
            $workingTimeBusiness = new \App\Business\WorkingTimeBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $workingTimeObj = $workingTimeBusiness->updateWorkingTime($data, $id);
            $this->dataResponse['data'] = $workingTimeObj;

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
     * @Route("application/api/v1/cong-viec-thuc-hien/{id}")
     */
    public function destroy($id, Request $request)
    {
        try {
            $workingTimeBusiness = new \App\Business\WorkingTimeBusiness($this->actor, $this->timeRequest);
            $result = $workingTimeBusiness->deleteWorkingTime($id);
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
     * @Route("application/api/v1/cong-viec-thuc-hien/export/{projectId}")
     */
    public function exportWorkingTime($projectId, Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $projectInfoObj = $projectManagementBusiness->getProjectInformationById($projectId); 
            $projectCode = $projectInfoObj->project_id;
            $workingTimeBusiness = new \App\Business\WorkingTimeBusiness($this->actor, $this->timeRequest);
            $pathToFile = $workingTimeBusiness->exportWorkingTime($projectId);
            $fileName = "CONG VIEC THUC HIEN $projectCode.xlsx";
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
