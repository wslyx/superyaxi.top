<?php
/**
 * Created by PhpStorm.
 * User: anguoyue
 * Date: 15/08/2018
 * Time: 10:58 AM
 */

class Manage_Config_UpdateController extends Manage_CommonController
{
    /**
     * 站点管理
     */
    public function doRequest()
    {
        $response = [];
        try {
            $config['lang'] = $this->language;

            $configKey = $_POST['key'];
            $configValue = $_POST['value'];

            $this->ctx->Wpf_Logger->error("manage.config.update", "ke=" . $configKey . " value=" . $configValue);

            if (!in_array($configKey, SiteConfig::$configKeys)) {
                throw new Exception("config key permission error");
            }

            if ("pluginPublicKey" == $configKey) {
                $configValue = $this->ctx->ZalyHelper->generateStrKey(32);
            }

            $result = $this->updateSiteConfig($configKey, $configValue);
            if ($result) {
                $response["errCode"] = "success";
            } else {
                $response["errCode"] = "error";
                $response["errInfo"] = 'update configValue error';
            }
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error("manage.config.update", $e);
            $response["errCode"] = "error";
            $response["errInfo"] = $e->getMessage();
        }

        echo json_encode($response);
        return;
    }


    private function updateSiteConfig($configKey, $configValue)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;

        try {
            $result = $this->ctx->SiteConfigTable->updateSiteConfig($configKey, $configValue);
            $this->ctx->Wpf_Logger->error("manage.config.update", "key=" . $configKey
                . " configValue=" . $configValue . " result=" . $result);

            if (!$result) {
                return $this->saveSiteConfig($configKey, $configValue);
            }

            return true;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
            return $this->saveSiteConfig($configKey, $configValue);
        }


        return false;
    }

    private function saveSiteConfig($configKey, $configValue)
    {
        $tag = __CLASS__ . "->" . __FUNCTION__;
        try {
            $result = $this->ctx->SiteConfigTable->insertSiteConfig($configKey, $configValue);

            $this->ctx->Wpf_Logger->error("manage.config.save", "key=" . $configKey
                . " configValue=" . $configValue . " result=" . $result);

            return $result;
        } catch (Exception $e) {
            $this->ctx->Wpf_Logger->error($tag, $e);
        }
        return false;
    }

}