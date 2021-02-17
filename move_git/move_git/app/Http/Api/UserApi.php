<?php

namespace App\Http\Api;
use Illuminate\Http\Request;

class UserApi extends ApiController
{
    /**
     * @Route("application/api/v1/user-application/", name="iodata.index")
     */
    public function index(Request $request)
    {
       
    }

    /**
     * @Route("application/api/v1/user-application", name="iodata.create")
     */
    public function create(Request $request)
    {
      
    }

    /**
     * @Route("application/api/v1/user-application/", name="iodata.store")
     */
    public function store(Request $request)
    {
        
    }


    /**
     * @Route("application/api/v1/user-application/")
     */
    public function show($id, Request $request)
    {
        
    }


    /**
     * @Route("application/api/v1/user-application/{id}", name="iodata.store")
     */
    public function update($id, Request $request)
    {
        try {

        } catch (\Exception $e) {

        }
    }

    /**
     * @Route("application/api/v1/user-application/{id}", name="iodata.delete")
     */
    public function destroy($id, Request $request)
    {
        try {
            
        } catch (\Exception $e) {
           
        }
    }

    
    /**
     * @Route("application/api/v1/user-application/current")
     */
    public function getCurrentUser(Request $request)
    {
        
    }
}
