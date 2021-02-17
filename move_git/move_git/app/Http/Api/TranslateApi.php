<?php

namespace App\Http\Api;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslateApi extends ApiController
{
    /**
     * @Route("application/api/v1/bien-phien-dich/")
     */
    public function index(Request $request)
    {
        try {
            $typeInfo = $request->input('typeInfo');
            $conditions = [
                'startDate' => $request->input('startDate'),
                'endDate' => $request->input('endDate'),
                'team' => $request->input('team')
            ];
            switch ($typeInfo) {
                case \App\Constants\Translate::TYPE_INFO_TO_TRANSLATE_LIST:
                    $translateList = new \App\Business\TranslateBusiness($this->actor, $this->timeRequest);
                    $data = $translateList->getTranslateListData($conditions);
                    break;
                case \App\Constants\Translate::TYPE_INFO_TRANSLATE_ACTION:
                    $data = '';
                    break;
                default:
                    throw new \Exception();
            }
            $this->dataResponse['data'] = $data;

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
     * @Route("application/api/v1/bien-phien-dich")
     */
    public function create(Request $request)
    {
        echo 'create';
    }

    /**
     * @Route("application/api/v1/bien-phien-dich/")
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
     * @Route("application/api/v1/bien-phien-dich/{id}")
     */
    public function show($id, Request $request)
    {
        try {
            $typeInfo = $request->input('typeInfo');
            switch ($typeInfo) {
                case \App\Constants\Translate::TYPE_INFO_TO_TRANSLATE_LIST:
                    $data = '';
                    break;
                case \App\Constants\Translate::TYPE_INFO_TRANSLATE_ACTION:
                    $translateBusiness = new \App\Business\TranslateBusiness($this->actor, $this->timeRequest);
                    $data = $translateBusiness->getTranslateItemData($id);
                    break;
                default:
                    throw new \Exception();
            }
            $this->dataResponse['data'] = $data;

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
     * @Route("application/api/v1/bien-phien-dich/{id}")
     */
    public function update($id, Request $request)
    {
        try {
            $data = $request->all();
            $translateBusiness = new \App\Business\TranslateBusiness($this->actor, $this->timeRequest);
            switch ($data['typeInfo']) {
                case \App\Constants\Translate::TYPE_INFO_TO_TRANSLATE_LIST:
                    $this->error = '';
                    $this->dataResponse['data'] = '';
                    $this->message = '';
                    break;
                case \App\Constants\Translate::TYPE_INFO_TRANSLATE_ACTION:
                    $this->error = $translateBusiness->validateTranslateData($data);
                    if(empty($this->error)){
                        $data = $translateBusiness->updateTranslateData($data, $id);
                        $this->dataResponse['data'] = $data;
                        $this->message = $translateBusiness->messageTranslateDataSuccessful($data);
                    }
                    break;
                default:
                    throw new \Exception();
            }
            
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
     * @Route("application/api/v1/bien-phien-dich/{id}")
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
