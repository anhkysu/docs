<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class QualityManagementApi extends ApiController
{
    /**
     * @Route("application/api/v1/kiem-soat-chat-luong/")
     */
    public function index(Request $request)
    {
        try {
            $typeInfo = $request->input('typeInfo');
            $conditions = [
                'startDate' => $request->input('startDate'),
                'endDate' => $request->input('endDate'),
                'team' => $request->input('team'),
                'staffId' => $request->input('staffId'),
            ];
            $ioDataBusiness = new \App\Business\InputOutputDataBusiness();
            switch ($typeInfo) {
                case \App\Constants\QualityManagement::TYPE_INFO_SEND_DATA_LIST:
                    $data = $ioDataBusiness->getSendDataList($conditions);
                    break;
                case \App\Constants\QualityManagement::TYPE_INFO_CHECKBACK_DATA_LIST:
                    $data = $ioDataBusiness->getCheckbackDataList($conditions);
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
        } catch (\Exception $e) {

            return response()->json([
                'data' => '',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/kiem-soat-chat-luong")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/kiem-soat-chat-luong/")
     */
    public function store(Request $request)
    {
        try {


            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' => $this->error,
            ], Response::HTTP_CREATED);
        } catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    /**
     * @Route("application/api/v1/kiem-soat-chat-luong/{id}")
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
     * @Route("application/api/v1/kiem-soat-chat-luong/{id}")
     */
    public function update($id, Request $request)
    {
        try {
            
            return response()->json([
                'data' => $this->dataResponse,
                'message' => $this->message,
                'error' =>$this->error,
            ], Response::HTTP_CREATED);

        } catch (\Exception $e) {

            return response()->json([
                'data' => null,
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @Route("application/api/v1/kiem-soat-chat-luong/{id}")
     */
    public function destroy($id, Request $request)
    {
        try {
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
}
