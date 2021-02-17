<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use App\NavigateClass;
use Symfony\Component\HttpFoundation\Response;

class QuotationTimeApi extends ApiController
{
    /**
     * @Route("application/api/v1/thoi-gian-bao-gia", name="quotation.time.create")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/thoi-gian-bao-gia", name="quotation.time.store")
     */
    public function store(Request $request)
    {
        try{
            $quotationTimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $this->dataResponse['data'] = $quotationTimeBusiness->addQuotationTimeList($data['quotationTimeList']);

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
     * @Route("application/api/v1/thoi-gian-bao-gia/", name="quotation.time.store")
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
     * @Route("application/api/v1/thoi-gian-bao-gia", name="quotation.time.store")
     */
    public function update($id, Request $request)
    {
        try{
            $quotationTimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $quotationTimeObj = $quotationTimeBusiness->updateQuotationTime($data, $id);
            $this->dataResponse['data'] = $quotationTimeObj;
            
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
     * @Route("application/api/v1/thoi-gian-bao-gia", name="quotation.time.destroy")
     */
    public function destroy($id)
    {
        try{
            $quotationTimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
            $result = $quotationTimeBusiness->deleteQuotationTime($id);
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
     * @Route("application/api/v1/thoi-gian-bao-gia/export/{projectId}", name="quotation.time.export")
     */
    public function exportQuotationTime($projectId, Request $request)
    {
        try{
            $projectManagementBusiness = new \App\Business\ProjectManagementBusiness($this->actor, $this->timeRequest);
            $projectInfoObj = $projectManagementBusiness->getProjectInformationById($projectId); 
            $projectCode = $projectInfoObj->project_id;
            $quotationTimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
            $pathToFile = $quotationTimeBusiness->exportQuotationTime($projectId);
            $fileName = "BAO GIO $projectCode.xlsx";
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

    /**
     * @Route("application/api/v1/thoi-gian-bao-gia/import", name="quotation.time.import")
     */
    public function importQuotationTime(Request $request)
    {
        try{
            $quotationTimeBusiness = new \App\Business\QuotationTimeBusiness($this->actor, $this->timeRequest);
            $data = $request->all();
            $this->dataResponse['data'] = $quotationTimeBusiness->importQuotationTime($data);

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
}
