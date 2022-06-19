<?php
/**
 * Created by PhpStorm.
 * User: zhangjun
 * Date: 06/08/2018
 * Time: 11:45 PM
 */

class Site_Login
{
    private $ctx;
    private $zalyError;
    private $sessionVerifyAction = "api.session.verify";
    private $pinyin;
    private $timeOut = 10;

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
        $this->zalyError = $this->ctx->ZalyErrorZh;
        $this->pinyin = new \Overtrue\Pinyin\Pinyin();
    }

    /**
     * 站点登陆逻辑
     *  1. presessionId(客户端提供)，站点通过presessionId调用平台，获取用户信息
     *  2. 获取用户登陆信息，进行站点本地登陆逻辑
     *  3. 构建Response返回
     */

    /**
     * @param $preSessionId
     * @param string $devicePubkPem
     * @param int $clientSideType
     * @return array
     * @throws Exception
     */
    public function checkPreSessionIdFromPlatform($preSessionId, $devicePubkPem = "", $clientSideType = Zaly\Proto\Core\UserClientType::UserClientMobileApp)
    {

        try {
            //get site config::publicKey
            $sitePriKeyPem = $this->getSiteConfigPriKeyFromDB();

            //get userProfile from platform
            $loginUserProfile = $this->getUserProfileFromPlatform($preSessionId, $sitePriKeyPem);

            //get intivation first
            $uicInfo = $this->getIntivationCode($loginUserProfile->getInvitationCode());

            $userProfile = $this->doSiteLoginAction($loginUserProfile, $devicePubkPem, $uicInfo, $clientSideType);

            //set site owner
            $this->checkAndSetSiteOwner($userProfile['userId'], $uicInfo);

            return $userProfile;
        } catch (Exception $ex) {
            $tag = __CLASS__ . "-" . __FUNCTION__;
            $this->ctx->Wpf_Logger->error($tag, " errorMsg = " . $ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }

    /**
     * 获取站点设置
     * @return string
     */
    private function getSiteConfigPriKeyFromDB()
    {
        try {
            $results = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_ID_PRIK_PEM);
            return $results[SiteConfig::SITE_ID_PRIK_PEM];
        } catch (Exception $ex) {
            $tag = __CLASS__ . "-" . __FUNCTION__;
            $this->ctx->Wpf_Logger->error($tag, "errorMsg = " . $ex->getMessage());
            return '';
        }
    }

    private function getUserProfileFromPlatform($preSessionId, $sitePrikPem)
    {
        $tag = __CLASS__ . '-' . __FUNCTION__;
        try {
            $sessionVerifyRequest = new \Zaly\Proto\Platform\ApiSessionVerifyRequest();
            $sessionVerifyRequest->setPreSessionId($preSessionId);

            $pluginIds = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_LOGIN_PLUGIN_ID);
            $pluginId = $pluginIds[SiteConfig::SITE_LOGIN_PLUGIN_ID];
            $sessionVerifyUrl = ZalyConfig::getSessionVerifyUrl($pluginId);
            $sessionVerifyUrl = ZalyHelper::getFullReqUrl($sessionVerifyUrl);

            $response = $this->ctx->ZalyCurl->httpRequestByAction('POST', $sessionVerifyUrl, $sessionVerifyRequest, $this->timeOut);

            ///获取数据
            $key = $response->getKey();
            $aesData = $response->getEncryptedProfile();
            $randomKey = $this->ctx->ZalyRsa->decrypt($key, $sitePrikPem);
            $serialize = $this->ctx->ZalyAes->decrypt($aesData, $randomKey);

            //获取LoginUserProfile
            $loginUserProfile = unserialize($serialize);

            return $loginUserProfile;
        } catch (Exception $ex) {
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            $this->ctx->Wpf_Logger->error($tag, "api.site.login error=" . $ex);
            throw new Exception($errorInfo);
        }
    }

    /**
     * 处理站点登陆具体逻辑
     *
     * @param Zaly\Proto\Platform\LoginUserProfile $loginUserProfile
     * @param $devicePubkPem
     * @param $uicInfo
     * @param $clientSideType
     * @return array
     * @throws Exception
     */
    private function doSiteLoginAction($loginUserProfile, $devicePubkPem, $uicInfo, $clientSideType)
    {
        if (!$loginUserProfile) {
            $errorCode = $this->zalyError->errorSession;
            $errorInfo = $this->zalyError->getErrorInfo($errorCode);
            throw new Exception($errorInfo);
        }
        $nameInLatin = $this->pinyin->permalink($loginUserProfile->getNickName(), "");

        $countryCode = $loginUserProfile->getPhoneCountryCode();

        if (!$countryCode) {
            $countryCode = "86";
        }

        $userProfile = [
            "userId" => $loginUserProfile->getUserId(),
            "loginName" => $loginUserProfile->getLoginName(),
            "nickname" => $loginUserProfile->getNickname(),
            "countryCode" => $countryCode,
            "loginNameLowercase" => strtolower($loginUserProfile->getLoginName()),
            "nicknameInLatin" => $nameInLatin,
            "phoneId" => $loginUserProfile->getPhoneNumber(),
            "timeReg" => $this->ctx->ZalyHelper->getMsectime(),
        ];

        $user = $this->checkUserExists($userProfile);
        if (!$user) {
            //no user ,register new user
            //check user invitation code and realName for phonenumber
            $this->verifyUicAndRealName($loginUserProfile->getUserId(), $loginUserProfile->getPhoneNumber(), $uicInfo);

            //save profile to db
            $userProfile['availableType'] = \Zaly\Proto\Core\UserAvailableType::UserAvailableNormal;
            $userProfile['avatar'] = ZalyAvatar::getRandomAvatar();

            $result = $this->insertSiteUserProfile($userProfile);

            if ($result) {
                $this->ctx->Site_Default->addDefaultFriendsAndGroups($userProfile['userId']);
            } else {
                // #TODO exception
                throw new Exception("insert user profile to db error");
            }

        }

        //这里
        $sessionInfo = $this->insertOrUpdateUserSession($userProfile, $devicePubkPem, $clientSideType);
        $userProfile['sessionId'] = $sessionInfo['sessionId'];
        $userProfile['deviceId'] = $sessionInfo['deviceId'];
        return $userProfile;
    }

    private function getIntivationCode($invitationCode)
    {
        if (empty($invitationCode)) {
            return false;
        }
        return $this->ctx->SiteUicTable->queryUicByCode($invitationCode);
    }

    private function checkUserExists($userProfile)
    {
        try {
            $user = $this->ctx->SiteUserTable->getUserByUserId($userProfile["userId"]);
            return $user;
        } catch (Exception $ex) {
            throw new Exception("check user is fail");
        }
    }

    /**
     * @param $userId
     * @param $phoneNumber
     * @param $uicInfo
     * @throws Exception
     */
    private function verifyUicAndRealName($userId, $phoneNumber, $uicInfo)
    {
        $configKeys = [SiteConfig::SITE_ENABLE_INVITATION_CODE, SiteConfig::SITE_ENABLE_REAL_NAME];
        $config = $this->ctx->SiteConfigTable->selectSiteConfig($configKeys);

        if ($config[SiteConfig::SITE_ENABLE_INVITATION_CODE]) {

            if (empty($uicInfo) || $uicInfo['status'] == 0 || $uicInfo['userId']) {
                $errorCode = $this->zalyError->errorInvitationCode;
                $errorInfo = $this->zalyError->getErrorInfo($errorCode);
                throw new Exception($errorInfo);
            }

            //update uic used
            $this->ctx->SiteUicTable->updateUicUsed($uicInfo['code'], $userId);
        }

        if ($config[SiteConfig::SITE_ENABLE_REAL_NAME]) {
            if (!$phoneNumber || !ZalyHelper::isPhoneNumber($phoneNumber)) {
                throw new Exception("phone number is error");
            }
        }
    }

    /**
     * save user profile
     *
     * @param $userProfile
     * @return bool
     * @throws Exception
     */
    private function insertSiteUserProfile($userProfile)
    {
        try {
            return $this->ctx->SiteUserTable->insertUserInfo($userProfile);
        } catch (Exception $e) {
            throw new Exception("insert user is fail");
        }
    }

    /**
     * 更新站点session
     *
     * @param $userProfile
     * @param $devicePubkPem
     * @param $clientSideType
     * @return string
     */
    private function insertOrUpdateUserSession($userProfile, $devicePubkPem, $clientSideType)
    {
        $sessionId = $this->ctx->ZalyHelper->generateStrId();
        $deviceId = sha1($devicePubkPem);

        try {
            ///TODO 需要替换
            $userId = $userProfile["userId"];
            $sessionInfo = [
                "sessionId" => $sessionId,
                "userId" => $userId,
                "deviceId" => $deviceId,
                "devicePubkPem" => $devicePubkPem,
                "timeWhenCreated" => $this->ctx->ZalyHelper->getMsectime(),
                "ipWhenCreated" => "",
                "timeActive" => $this->ctx->ZalyHelper->getMsectime(),
                "ipActive" => "",
//                "userAgent" => "",
//                "userAgentType" => "",
                "clientSideType" => $clientSideType,
            ];
            $this->ctx->SiteSessionTable->insertSessionInfo($sessionInfo);
        } catch (Exception $ex) {
            $userId = $userProfile["userId"];
            $sessionInfo = [
                "sessionId" => $sessionId,
                "timeActive" => $this->ctx->ZalyHelper->getMsectime(),
                "ipActive" => "",
//                "userAgent" => "",
//                "userAgentType" => "",
                "clientSideType" => $clientSideType,
            ];
            $where = [
                "userId" => $userId,
                "deviceId" => $deviceId,
            ];
            $this->ctx->SiteSessionTable->updateSessionInfo($where, $sessionInfo);
        }

        $sessionInfo['sessionId'] = $sessionId;
        $sessionInfo['deviceId'] = $deviceId;
        return $sessionInfo;
    }

    /**
     * @param $userId
     * @param $uicInfo
     */
    private function checkAndSetSiteOwner($userId, $uicInfo)
    {
        $siteOwner = $this->ctx->Site_Config->getSiteOwner();

        if (empty($siteOwner)) {
            $this->ctx->Wpf_Logger->info("api.site.login", "uic info=" . json_encode($uicInfo));
            if ($uicInfo && $uicInfo['status'] == 100) {
                //set site owner
                $this->ctx->SiteConfigTable->updateSiteConfig(SiteConfig::SITE_OWNER, $userId);

                //update config realName = false
                $this->ctx->SiteConfigTable->updateSiteConfig(SiteConfig::SITE_ENABLE_INVITATION_CODE, 0);
            }

        }
    }
}