<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\NavigateClass;

class JointStaffApi extends ApiController
{
    /**
     * @Route("application/api/v1/thanh-vien/", name="jointstaff.index")
     */
    public function index(Request $request)
    {
        
    }

    /**
     * @Route("application/api/v1/thanh-vien", name="jointstaff.create")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/thanh-vien/", name="jointstaff.store")
     */
    public function store(Request $request)
    {
        
    }

    /**
     * @Route("application/api/v1/thanh-vien/", name="jointstaff.store")
     */
    public function show($id, Request $request)
    {
        
    }


    /**
     * @Route("application/api/v1/thanh-vien/{id}", name="jointstaff.store")
     */
    public function update($id, Request $request)
    {
        
    }

    /**
     * @Route("application/api/v1/thanh-vien/{id}", name="jointstaff.delete")
     */
    public function destroy($id, Request $request)
    {
        try{
            $jointStaffBusiness = new \App\Business\JointStaffBusiness($this->actor, $this->timeRequest);
            $result = $jointStaffBusiness->deleteJointStaff($id);
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
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/thanh-vien/load-data", name="jointstaff.loaddata")
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
