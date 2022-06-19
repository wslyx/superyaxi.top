<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 20/08/2018
 * Time: 4:48 PM
 */

class Page_JsController extends  HttpBaseController
{
    public  function doIndex()
    {
//        parent::doIndex(); // TODO: Change the autogenerated stub
        $this->index();
    }


    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        $loginName = isset($_GET['loginName']) ? $_GET['loginName'] : "";

        if(!$loginName){
            exit;
        }
        $userInfo = $this->ctx->SiteUserTable->getUserByLoginName($loginName);
        $callBackSuccess = isset($_GET['success_callback']) ? $_GET['success_callback'] : "";
        $callBackFail    = isset($_GET['fail_callback']) ? $_GET['fail_callback'] : "";
        $isReqType = isset($_GET['isReqType']) ? $_GET['isReqType'] : "";

        if($isReqType == "proxy") {
            if($userInfo) {
                echo "success";
            } else {
                echo "fail";
            }
        } else {
            if($userInfo) {
                echo "$callBackSuccess()";
            } else {
                echo "$callBackFail()";
            }
        }

    }
}