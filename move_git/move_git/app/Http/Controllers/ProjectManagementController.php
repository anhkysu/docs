<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 7/26/18
 * Time: 8:37 PM
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProjectManagementController extends Controller
{
    function _init()
    {
        $this->_pageTitle = trans('page.page_title.project_management');
        // TODO: Implement _init() method.
    }

    public function indexAction(Request $request)
    {
        $dropdownBusiness = \App\NavigateClass::getInstance('Business_DropdownBusiness');
        $this->dataResponse['dropdownList'] = $dropdownBusiness->getDropDownInProjectManagement();
        $projectInfomationModel = new \App\Models\ProjectInformation();
        $projectListByUserFilterer['staffId'] = $this->_actor;
        $userRelatedProjectList = $projectInfomationModel->selectProjectInformations($projectListByUserFilterer, $this->_actor);
        $this->dataResponse['userRelatedProjectList'] = $userRelatedProjectList;
        
        return view("project.project_index", $this->dataResponse);
    }
    
    /**
     * @Route("chi-tiet/{id}", name="view.project.page")
     * @param Request $request
     */
    public function viewProjectDetailAction($projectId, Request $request)
    {
        $this->_pageTitle = $projectId;
        $dropdownBusiness = \App\NavigateClass::getInstance('Business_DropdownBusiness');
        $this->dataResponse['dropdownList'] = $dropdownBusiness->getDropDownInProjectManagement();
        $this->dataResponse['projectId'] = $projectId;
        $this->dataResponse['pageTitle'] = $this->_pageTitle;
        
        return view("project.project_detail", $this->dataResponse);
    }
}   