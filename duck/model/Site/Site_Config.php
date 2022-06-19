<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 4:44 PM
 */

class Site_Config
{

    private $ctx;

    public function __construct(BaseCtx $ctx)
    {
        $this->ctx = $ctx;
    }


    /**
     * @param $configKey
     * @param null $defaultValue
     * @return null
     */
    public function getConfigValue($configKey, $defaultValue = null)
    {
        $configValues = $this->ctx->SiteConfigTable->selectSiteConfig($configKey);
        if ($configValues) {
            return $configValues[$configKey];
        }
        return $defaultValue;
    }

    public function getFileSizeConfig()
    {
        return $this->getConfigValue(SiteConfig::SITE_FILE_SIZE, 10);
    }

    public function getAllConfig()
    {
        return $this->ctx->SiteConfigTable->selectSiteConfig();
    }

    /**
     * get administrator,site has just one administrator
     * @return null
     */
    public function getSiteOwner()
    {
        $adminValue = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_OWNER);

        if (isset($adminValue)) {
            return $adminValue[SiteConfig::SITE_OWNER];
        }

        return null;
    }


    public function isSiteOwner($userId)
    {
        $siteOwner = $this->getSiteOwner();
        if (empty($userId) || empty($siteOwner)) {
            return false;
        }

        if ($userId == $siteOwner) {
            return true;
        }
    }

    /**
     * get managers ,site has many managers
     *
     * @return array
     */
    public function getSiteManagers()
    {
        $managers = [];

        $admin = $this->getSiteOwner();

        if (isset($admin)) {
            $managers[] = $admin;
        }

        $managersValue = $this->ctx->SiteConfigTable->selectSiteConfig(SiteConfig::SITE_MANAGERS);

        if ($managersValue) {
            $managersValueStr = isset($managersValue['managers']) ? $managersValue['managers'] : "";
            $managersArray = explode(",", $managersValueStr);
            if (!empty($managersArray)) {
                $managers = array_merge($managers, $managersArray);
            }

        }

        return $managers;
    }

    public function isManager($userId)
    {
        if (empty($userId)) {
            return false;
        }

        if (in_array($userId, $this->getSiteManagers())) {
            return true;
        }

    }

    public function getSiteDefaultFriendsAndGroups()
    {
        return $this->ctx->SiteConfigTable->selectSiteConfig([SiteConfig::SITE_DEFAULT_FRIENDS, SiteConfig::SITE_DEFAULT_GROUPS]);
    }

}