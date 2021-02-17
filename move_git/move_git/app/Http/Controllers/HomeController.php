<?php
/**
 * Created by PhpStorm.
 * User: macintosh
 * Date: 7/26/18
 * Time: 8:37 PM
 */

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    function _init()
    {
        $this->_pageTitle = trans('page.page_title.home');
        // TODO: Implement _init() method.
    }

    public function indexAction(Request $request)
    {
        $dropdownBusiness = \App\NavigateClass::getInstance('Business_DropdownBusiness');
        $drdProjectMng = $dropdownBusiness->getDropDownInProjectManagement();
        $drdTranslate = $dropdownBusiness->getDropDownInTranslate();
        $this->dataResponse['dropdownList'] = array_merge($drdProjectMng, $drdTranslate);

        return view("home.home_index", $this->dataResponse);
    }
}