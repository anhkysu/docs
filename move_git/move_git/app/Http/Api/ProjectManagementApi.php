<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use App\NavigateClass;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProjectManagementApi extends ApiController
{
    /**
     * @Route("application/api/v1/quan-ly-du-an/", name="project.management.search")
     */
    public function searchAction(Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $conditions = $request->all();
            $projectInformationList = $projectManagementBusiness->getProjectInformations($conditions);
            $this->dataResponse['projectInformationList'] = $projectInformationList;

            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_OK);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("/application/api/v1/quan-ly-du-an/", name="project.management.create")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/quan-ly-du-an/", name="project.managment.store")
     */
    public function store(Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $this->error = $projectManagementBusiness->validateProjectInformation($data['projectInfo']);
            if(empty($this->error)){
                $projectId = $projectManagementBusiness->createProject($data);
                $this->dataResponse['projectId'] = $projectId;
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
     * @Route("/application/api/v1/quan-ly-du-an/", name="project.management.show")
     */
    public function show($id, Request $request)
    {
        try{
            $conditions = [];
            $search = $request->input('search');
            $typeInfo = $request->input('typeInfo');
            switch($typeInfo){
                case \App\Constants\ProjectManagement::TYPE_INFO_JOINT_STAFF:
                    $jointStaffBusiness = new \App\Business\JointStaffBusiness($this->actor, $this->timeRequest);
                    $data = $jointStaffBusiness->getJointStaffList($id);
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_IO_DATA:
                    $inputOutputDataBusiness = new \App\Business\InputOutputDataBusiness($this->actor, $this->timeRequest);
                    $limit = $request->input('limit');
                    $data = $inputOutputDataBusiness->getInputOutputDataList($id, $limit, $search);
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_QUOTATION_TIME:
                    $quotationtimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
                    $limit = $request->input('limit');
                    $data = $quotationtimeBusiness->getQuotationTimeList($id, $limit, $search);
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_TECHNICAL_ERROR:
                    $technicalErrorBusiness = new \App\Business\TechnicalErrorBusiness($this->actor, $this->timeRequest);
                    $limit = $request->input('limit');
                    $data = $technicalErrorBusiness->getTechnicalErrorList($id, $limit);
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_WORKING_TIME:
                    $workingTimeBusiness = new \App\Business\WorkingTimeBusiness($this->actor, $this->timeRequest);
                    $limit = $request->input('limit');
                    $data = $workingTimeBusiness->getWorkingTimeList($id, $limit);
                    break;
                default:
                throw new \Exception();
            }
            $this->dataResponse['data'] = $data;
            $this->dataResponse['typeInfo'] = $typeInfo;
            
            return response()->json([
                'data' => $this->dataResponse,
                'error' => '',
            ], Response::HTTP_OK);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'typeInfo' => $typeInfo,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("/application/api/v1/quan-ly-du-an/", name="project.management.edit")
     */
    public function update($id, Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $typeInfo = $data['typeInfo'];
            switch($typeInfo){
                case \App\Constants\ProjectManagement::TYPE_INFO_PROJECT_INFO: 
                    $this->error = $projectManagementBusiness->validateProjectInformation($data['projectData']['projectInfo']);
                    if(empty($this->error)){
                        $projectManagementBusiness->updateProjectInformation($data['projectData'], $id);
                        $this->dataResponse['data'] = $data;
                    }
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_JOINT_STAFF:
                    $jointStaffBusiness = new \App\Business\JointStaffBusiness(1, $this->timeRequest);
                    $jointStaffBusiness->addJointStaffList($data['newStaffList'], $id);
                    $jointStaffList = $jointStaffBusiness->getJointStaffList($id);
                    $this->dataResponse['data'] = $jointStaffList;
                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_IO_DATA:

                    break;
                case \App\Constants\ProjectManagement::TYPE_INFO_QUOTATION_TIME:

                    break;
                default:
                throw new \Exception();
            }
            $this->dataResponse['typeInfo'] = $typeInfo;

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

    public function findProjectsUserBelongsTo(Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $conditions = $request->all();
            $projectOfUserList = $projectManagementBusiness->getProjectInformations($conditions);
            $headers = [
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Cache-Control' => 'private',
                'Cache-Control' => 'max-age=120',
            ];

            return response()
                ->json([
                'data' => $projectOfUserList,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_OK)->withHeaders($headers);
        }catch(\Exception $e){

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
