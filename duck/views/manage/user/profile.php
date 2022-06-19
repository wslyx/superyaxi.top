<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title><?php if ($lang == "1") { ?>用户资料<?php } else { ?>User Profile<?php } ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <style>

        html, body {
            padding: 0px;
            margin: 0px;
            font-family: PingFangSC-Regular, "MicrosoftYaHei";
            /*overflow: hidden;*/
            width: 100%;
            height: 100%;
            background: rgba(245, 245, 245, 1);
            font-size: 14px;
            overflow-x: hidden;
        }

        /* mask and new window */
        .wrapper-mask {
            background: rgba(0, 0, 0, 0.8);
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            position: fixed;
            z-index: 9999;
            overflow: hidden;
            visibility: hidden;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            width: 100%;
            /*height: 100%;*/
            /*display: flex;*/
            align-items: stretch;
        }

        .layout-all-row {
            width: 100%;
            /*background: white;*/
            background: rgba(245, 245, 245, 1);;
            display: flex;
            /*align-items: stretch;*/
            overflow: hidden;
            flex-shrink: 0;
        }

        .item-row {
            width: 100%;
            background: rgba(255, 255, 255, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 44px;
        }

        /*.item-row:hover{*/
        /*background: rgba(255, 255, 255, 0.2);*/
        /*}*/

        .item-row:active {
            background: rgba(255, 255, 255, 0.2);
        }

        .item-bottom {
            background: rgba(245, 244, 249, 1);
            display: flex;
            flex-direction: row;
            text-align: center;
            height: 25px;
        }

        .item-header {
            width: 50px;
            height: 50px;
        }

        .site-manage-image {
            width: 40px;
            height: 40px;
            margin-top: 5px;
            margin-bottom: 5px;
            margin-left: 16px;
            /*border-radius: 50%;*/
        }

        .site-logo-image {
            width: 30px;
            height: 30px;
            /*margin-top: 5px;*/
            margin-bottom: 7px;
            /*border-radius: 50%;*/
        }

        .item-body {
            width: 100%;
            height: 44px;
            /*margin-left: 1rem;*/
            /*margin-top: 5px;*/
            flex-direction: row;
            vertical-align: middle;
        }

        .list-item-center {
            width: 100%;
            /*height: 11rem;*/
            /*background: rgba(255, 255, 255, 1);*/
            padding-bottom: 11px;
            /*padding-left: 1rem;*/

        }

        .item-body-display {
            display: flex;
            justify-content: space-between;
            /*margin-right: 7rem;*/
            /*margin-bottom: 3rem;*/
            /*height: 100%;*/
            /*line-height: 3rem;*/
            margin-top: 7px;
        }

        .item-body-tail {
            text-align: right;
            margin-right: 10px;
            margin-bottom: 10px;
            font-size: 16px;
            display: flex;
            /*height: 3rem;*/
            /*color: rgba(76, 59, 177, 1);*/
            /*line-height: 3rem;*/
        }

        .item-body-desc {
            /*height: 3rem;*/
            font-size: 16px;
            /*color: rgba(76, 59, 177, 1);*/
            margin-top: 5px;
            margin-left: 10px;
        }

        .more-img {
            width: 8px;
            height: 13px;
            margin-top: 5px;
            /*border-radius: 50%;*/
        }

        .line {
            width: 250px;
            height: 1px;
            background: rgba(201, 201, 201, 1);
            border: 0.1px solid rgba(201, 201, 201, 1);
            overflow: hidden;
            text-align: center;
            margin: 0 auto;
        }

        .division-line {
            height: 1px;
            background: rgba(243, 243, 243, 1);
            margin-left: 40px;
            overflow: hidden;
        }

        #popup-group {
            width: 320px;
            height: 300px;
            background: rgba(255, 255, 255, 1);
            border-radius: 10px;
        }

        .header_tip_font {
            justify-content: center;
            text-align: center;
            margin-top: 29px;
            height: 24px;
            font-size: 24px;
            font-weight: bold;
            color: #4C3BB1;
            font-family: PingFangSC;
            /*line-height: 3.75rem;*/
        }

        .popup-group-input {
            background-color: #ffffff;
            border-style: none;
            outline: none;
            /*height: 1.88rem;*/
            font-size: 20px;
            font-family: PingFangSC-Regular;
            /*color: rgba(205, 205, 205, 1);*/
            line-height: 20px;
            margin-top: 65px;
            width: 250px;
            height: 20px;
            overflow: hidden;
        }

        .plugin-add-input {
            background-color: #ffffff;
            border-style: none;
            outline: none;
            font-size: 14px;
            font-family: PingFangSC-Regular;
            /*color: rgba(205, 205, 205, 1);*/
            /*line-height: 1.88rem;*/
            /*margin-left: 10rem;*/
            padding: 0.5rem;
            width: 200px;
            height: 5px;
            overflow: hidden;
            text-align: right;
        }

        .data_tip {
            height: 1.69rem;
            font-size: 1.31rem;
            font-family: PingFangSC-Regular;
            color: rgba(153, 153, 153, 1);
            line-height: 1.69rem;
            margin-left: 23rem;
            width: 29rem;
            word-break: break-all;
            padding: 0.5rem;
        }

        .create_button,
        .create_button:hover,
        .create_button:focus,
        .create_button:active {
            margin-top: 45px;
            width: 250px;
            height: 50px;
            background: rgba(76, 59, 177, 1);
            border-width: 0px;
            border-radius: 7px;
            font-size: 16px;
            color: rgba(255, 255, 255, 1);
        }

        .weui_switch {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            position: relative;
            width: 52px;
            height: 32px;
            border: 1px solid #DFDFDF;
            outline: 0;
            border-radius: 16px;
            box-sizing: border-box;
            background: #DFDFDF;
        }

        .weui_switch:checked {
            border-color: #4C3BB1;
            /*">#04BE02;*/
            background-color: #4C3BB1;
        }

        .weui_switch:before {
            content: " ";
            position: absolute;
            top: 0;
            left: 0;
            width: 50px;
            height: 30px;
            border-radius: 15px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            border-bottom-right-radius: 15px;
            border-bottom-left-radius: 15px;
            background-color: #FDFDFD;
            -webkit-transition: -webkit-transform .3s;
            transition: -webkit-transform .3s;
            transition: transform .3s;
            transition: transform .3s, -webkit-transform .3s;
        }

        .weui_switch:checked:before {
            -webkit-transform: scale(0);
            transform: scale(0);
        }

        .weui_switch:after {
            content: " ";
            position: absolute;
            top: 0;
            left: 0;
            width: 30px;
            height: 30px;
            border-radius: 15px;
            background-color: #FFFFFF;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.4);
            -webkit-transition: -webkit-transform .3s;
            transition: -webkit-transform .3s;
            transition: transform .3s;
            transition: transform .3s, -webkit-transform .3s;
        }

        .weui_switch:checked:after {
            -webkit-transform: translateX(20px);
            transform: translateX(20px);
        }

        .site-image {
            width: 30px;
            height: 30px;
            /*margin-top: 5px;*/
            margin-bottom: 7px;
            /*border-radius: 50%;*/
            cursor: pointer;
        }

        .item-body-value {
            line-height: 28px;
            /*margin-top: 5px;*/
            margin-right: 5px;
        }

    </style>

    <script type="text/javascript" src="../../public/jquery/jquery-3.3.1.min.js"></script>
    <script type="text/javascript">

        function isAndroid() {

            var userAgent = window.navigator.userAgent.toLowerCase();
            if (userAgent.indexOf("android") != -1) {
                return true;
            }

            return false;
        }

        function isMobile() {
            if (/Android|webOS|iPhone|iPod|BlackBerry/i.test(navigator.userAgent)) {
                return true;
            }
            return false;
        }

        function getLanguage() {
            var nl = navigator.language;
            if ("zh-cn" == nl || "zh-CN" == nl) {
                return 1;
            }
            return 0;
        }


        function zalyjsAjaxPostJSON(url, body, callback) {
            zalyjsAjaxPost(url, jsonToQueryString(body), function (data) {
                var json = JSON.parse(data)
                callback(json)
            })
        }


        function zalyjsNavOpenPage(url) {
            var messageBody = {}
            messageBody["url"] = url
            messageBody = JSON.stringify(messageBody)

            if (isAndroid()) {
                window.Android.zalyjsNavOpenPage(messageBody)
            } else {
                window.webkit.messageHandlers.zalyjsNavOpenPage.postMessage(messageBody)
            }
        }

        function zalyjsCommonAjaxGet(url, callBack) {
            $.ajax({
                url: url,
                method: "GET",
                success: function (result) {

                    callBack(url, result);

                },
                error: function (err) {
                    alert("error");
                }
            });

        }


        function zalyjsCommonAjaxPost(url, value, callBack) {
            $.ajax({
                url: url,
                method: "POST",
                data: value,
                success: function (result) {
                    callBack(url, value, result);
                },
                error: function (err) {
                    alert("error");
                }
            });

        }

        function zalyjsCommonAjaxPostJson(url, jsonBody, callBack) {
            $.ajax({
                url: url,
                method: "POST",
                data: jsonBody,
                success: function (result) {

                    callBack(url, jsonBody, result);

                },
                error: function (err) {
                    alert("error");
                }
            });

        }

        /**
         * _blank    在新窗口中打开被链接文档。
         * _self    默认。在相同的框架中打开被链接文档。
         * _parent    在父框架集中打开被链接文档。
         * _top    在整个窗口中打开被链接文档。
         * framename    在指定的框架中打开被链接文档。
         *
         * @param url
         * @param target
         */
        function zalyjsCommonOpenPage(url) {
            // window.open(url, target);
            location.href = url;
        }

    </script>
</head>

<body>

<!--<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>-->

<div class="wrapper" id="wrapper">

    <!--  site basic config  -->
    <div class="layout-all-row" id="user-id" data="<?php echo $userId; ?>">

        <div class="list-item-center">

            <div class="item-row" onclick="showUserId('<?php echo $userId; ?>')">
                <div class="item-body">
                    <div class="item-body-display user-id-body">
                        <div class="item-body-desc">ID</div>

                        <div class="item-body-tail" id="user-id-value">
                            <div class="item-body-value"><?php
                                if (isset($userId)) {
                                    $subUserId = substr($userId, 0, 4) . " **** ";
                                    $subUserId .= substr($userId, -4);
                                    echo $subUserId;
                                }
                                ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row" id="user-nickname">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">用户昵称</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Nickname</div>
                        <?php } ?>

                        <div class="item-body-tail" id="user-nickname-text">
                            <div class="item-body-value"><?php echo $nickname; ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>


            <!--      part1: site name      -->
            <div class="item-row" id="user-loginName">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">登陆名</div>
                        <?php } else { ?>
                            <div class="item-body-desc">LoginName</div>
                        <?php } ?>


                        <div class="item-body-tail" id="user-nickname-text">
                            <div class="item-body-value"><?php echo $loginName; ?></div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>

                    </div>

                </div>
            </div>
            <div class="division-line"></div>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">用户头像</div>
                        <?php } else { ?>
                            <div class="item-body-desc">User Avatar</div>
                        <?php } ?>


                        <div class="item-body-tail" id="user-avatar-img-id" fileId="<?php echo $avatar ?>">
                            <div class="item-body-value">
                                <img id="user-avatar-img" class="site-image"
                                     onclick="uploadFile('user-avatar-img-input')"
                                     src="../../public/img/msg/default_user.png">

                                <input id="user-avatar-img-input" type="file" onchange="uploadImageFile(this)"
                                       accept="image/gif,image/jpeg,image/jpg,image/png,image/svg"
                                       style="display: none;">
                            </div>
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!-- part 2  register && login plugin-->
    <div class="layout-all-row">

        <div class="list-item-center">

            <?php if (!$isSiteOwner) { ?>

                <div class="item-row">
                    <div class="item-body">
                        <div class="item-body-display">
                            <?php if ($lang == "1") { ?>
                                <div class="item-body-desc">设为站点管理员</div>
                            <?php } else { ?>
                                <div class="item-body-desc">Add Site Manager</div>
                            <?php } ?>


                            <div class="item-body-tail">
                                <?php if ($isSiteManager == 1) { ?>
                                    <input id="addSiteManagerSwitch" class="weui_switch" type="checkbox" checked>
                                <?php } else { ?>
                                    <input id="addSiteManagerSwitch" class="weui_switch" type="checkbox">
                                <?php } ?>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="division-line"></div>
            <?php } ?>

            <div class="item-row">
                <div class="item-body">
                    <div class="item-body-display">
                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">设为站点默认好友</div>
                        <?php } else { ?>
                            <div class="item-body-desc">Add Site Default Friend</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <?php if ($isDefaultFriend == 1) { ?>
                                <input id="addDefaultFriendSwitch" class="weui_switch" type="checkbox" checked>
                            <?php } else { ?>
                                <input id="addDefaultFriendSwitch" class="weui_switch" type="checkbox">
                            <?php } ?>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>

        </div>

    </div>


    <!--   part 3  -->
    <div class="layout-all-row">

        <div class="list-item-center">
            <div class="item-row" id="user-group-list">
                <div class="item-body">
                    <div class="item-body-display">

                        <?php if ($lang == "1") { ?>
                            <div class="item-body-desc">用户群组列表</div>
                        <?php } else { ?>
                            <div class="item-body-desc">User Group List</div>
                        <?php } ?>

                        <div class="item-body-tail">
                            <img class="more-img"
                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>
                        </div>
                    </div>

                </div>
            </div>
            <div class="division-line"></div>
        </div>
    </div>


    <!--   part 4  -->
    <!--    <div class="layout-all-row">-->
    <!---->
    <!--        <div class="list-item-center">-->
    <!--            <div class="item-row" id="remove-user">-->
    <!--                <div class="item-body">-->
    <!--                    <div class="item-body-display">-->
    <!---->
    <!--                        --><?php //if ($lang == "1") { ?>
    <!--                            <div class="item-body-desc">删除用户账号</div>-->
    <!--                        --><?php //} else { ?>
    <!--                            <div class="item-body-desc">Remove User Account</div>-->
    <!--                        --><?php //} ?>
    <!---->
    <!--                        <div class="item-body-tail">-->
    <!--                            <img class="more-img"-->
    <!--                                 src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAnCAYAAAAVW4iAAAABfElEQVRIS8WXvU6EQBCAZ5YHsdTmEk3kJ1j4HDbGxMbG5N7EwkIaCy18DxtygMFopZ3vAdkxkMMsB8v+XqQi2ex8ux/D7CyC8NR1fdC27RoRszAMv8Ux23ccJhZFcQoA9wCQAMAbEd0mSbKxDTzM6wF5nq+CIHgGgONhgIi+GGPXURTlLhDstDRN8wQA5zOB3hljFy66sCzLOyJaL6zSSRdWVXVIRI9EdCaDuOgavsEJY+wFEY8WdmKlS5ZFMo6xrj9AF3EfukaAbcp61TUBdJCdn85J1yzApy4pwJeuRYAPXUqAqy4tgIsubYCtLiOAjS5jgKkuK8BW1w0APCgOo8wKMHcCzoA+AeDSGKA4AXsOEf1wzq/SNH01AtjUKG2AiZY4jj9GXYWqazDVIsZT7sBGizbAVosWwEWLEuCqZRHgQ4sU4EvLLMCnlgnAt5YRYB9aRoD/7q77kivWFlVZ2R2XdtdiyTUNqpNFxl20bBGT7ppz3t12MhctIuwXEK5/O55iCBQAAAAASUVORK5CYII="/>-->
    <!--                        </div>-->
    <!--                    </div>-->
    <!---->
    <!--                </div>-->
    <!--            </div>-->
    <!--            <div class="division-line"></div>-->
    <!---->
    <!--            <div class="item-bottom">-->
    <!---->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </div>-->

</div>

<div class="wrapper-mask" id="wrapper-mask" style="visibility: hidden;"></div>

<div class="popup-template" style="display:none;">

    <div class="config-hidden" id="popup-group">

        <div class="flex-container">
            <div class="header_tip_font popup-group-title">创建群组</div>
        </div>

        <div class="" style="text-align: center">
            <input type="text" class="popup-group-input"
                   data-local-placeholder="enterGroupNamePlaceholder" placeholder="please input">
        </div>

        <div class="line"></div>

        <div class="" style="text-align:center;">
            <?php if ($lang == "1") { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();"> 修改
                </button>
            <?php } else { ?>
                <button id="update-user-button" type="button" class="create_button" data=""
                        onclick="updateConfirm();">Update
                </button>
            <?php } ?>
        </div>

    </div>

</div>


<script type="text/javascript">

    $(function () {
        var fileId = $("#user-avatar-img-id").attr("fileId");
        showImage(fileId, 'user-avatar-img');
    });

    function uploadFile(obj) {
        $("#" + obj).val("");
        $("#" + obj).click();
    }

    downloadFileUrl = "./index.php?action=http.file.downloadFile";

    function showImage(fileId, htmlImgId) {

        var requestUrl = "./_api_file_download_/test?fileId=" + fileId;


        if (!isMobile()) {
            requestUrl = downloadFileUrl + "&fileId=" + fileId + "&returnBase64=0";
        }

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && (this.status == 200 || this.status == 304)) {
                var blob = this.response;
                var src = window.URL.createObjectURL(blob);

                $("#" + htmlImgId).attr("src", src);
            }
        };
        xhttp.open("GET", requestUrl, true);
        xhttp.responseType = "blob";
        // xhttp.setRequestHeader('Cache-Control', "max-age=2592000, public");
        xhttp.send();
    }

    function uploadImageFile(obj) {
        if (obj) {
            if (obj.files) {
                var formData = new FormData();

                formData.append("file", obj.files.item(0));
                formData.append("fileType", "FileImage");
                formData.append("isMessageAttachment", false);

                var src = window.URL.createObjectURL(obj.files.item(0));

                uploadFileToServer(formData, src);

                //直接放图片
                $("#user-avatar-img").attr("src", src);
            }
            return obj.value;
        }

    }

    function uploadFileToServer(formData, src) {
        var url = "./index.php?action=http.file.uploadWeb";

        if (isMobile()) {
            url = "/_api_file_upload_/?fileType=1";  //fileType=1,表示文件
        }

        $.ajax({
            url: url,
            type: "post",
            data: formData,
            contentType: false,
            processData: false,
            success: function (imageFileIdResult) {
                if (imageFileIdResult) {
                    var fileId = imageFileIdResult;
                    if (isMobile()) {
                        var res = JSON.parse(imageFileIdResult);
                        fileId = res.fileId;
                    }
                    updateServerImage(fileId);
                } else {
                    alert(getLanguage() == 1 ? "上传返回结果空 " : "empty response");
                }
            },
            error: function (err) {
                alert("update image error");
                // return false;
            }
        });
    }

    function updateServerImage(fileId) {
        var userId = $("#user-id").attr("data");
        var url = "index.php?action=manage.user.update&lang=" + getLanguage();

        var data = {
            'userId': userId,
            'key': 'avatar',
            'value': fileId,
        };
        zalyjsCommonAjaxPostJson(url, data, updateAvatarResponse);
    }

    function updateAvatarResponse(url, data, result) {
        var res = JSON.parse(result);
        if (res.errCode != "success") {
            return getLanguage() == 1 ? "更新头像失败" : "update user avatar fail";
        }
    }

</script>


<script type="text/javascript">

    function showWindow(jqElement) {
        jqElement.css("visibility", "visible");
        $(".wrapper-mask").css("visibility", "visible").append(jqElement);
    }


    function removeWindow(jqElement) {
        jqElement.remove();
        $(".popup-template").append(jqElement);
        $(".wrapper-mask").css("visibility", "hidden");
        $("#update-user-button").attr("data", "");
        $(".popup-group-input").val("");
        $(".popup-template").hide();
    }


    // $(document).mouseup(function (e) {
    $(".wrapper-mask").mouseup(function (e) {
        var targetId = e.target.id;
        var targetClassName = e.target.className;

        if (targetId == "wrapper-mask") {
            var wrapperMask = document.getElementById("wrapper-mask");
            var length = wrapperMask.children.length;
            var i;
            for (i = 0; i < length; i++) {
                var node = wrapperMask.children[i];
                node.remove();
                // addTemplate(node);
                $(".popup-template").append(node);
                $(".popup-template").hide();
            }
            $("#update-user-button").attr("data", "");
            wrapperMask.style.visibility = "hidden";
        }
    });


    function showUserId(userId) {
        var url = "index.php?action=manage.user.id&userId=" + userId + "&lang=" + getLanguage();
        zalyjsCommonOpenPage(url);
    }


    $("#user-nickname").click(function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "nickname");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);

    });

    $("#user-loginName").click(function () {
        var title = $(this).find(".item-body-desc").html();
        var inputBody = $(this).find(".item-body-value").html();

        $("#update-user-button").attr("data", "loginName");
        showWindow($(".config-hidden"));

        $(".popup-group-title").html(title);
        $(".popup-group-input").val(inputBody);
    });


    function updateConfirm() {
        var userId = $("#user-id").attr("data");
        var value = $(".popup-group-input").val();
        var nameData = $("#update-user-button").attr("data");

        if (nameData == null || nameData == "") {
            alert("update fail");
            return;
        }

        var data = {
            'userId': userId,
            'key': nameData,
            'value': value
        };

        var url = "index.php?action=manage.user.update&lang=" + getLanguage();

        zalyjsCommonAjaxPostJson(url, data, updateNameResponse);

        removeWindow($(".config-hidden"));
    }

    function updateNameResponse(url, data, result) {
        var res = JSON.parse(result);

        if (res.errCode != "success") {
            alert(getLanguage() == 1 ? "更新成功" : "update name error");
        }

        location.reload();
    }

    //enable realName
    $("#addSiteManagerSwitch").change(function () {

        var userId = $("#user-id").attr("data");
        var isChecked = $(this).is(':checked')
        var url = "index.php?action=manage.user.update&lang=" + getLanguage();


        var data = {
            'userId': userId,
            'key': 'addSiteManager',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, addManagerResponse);

    });

    function addManagerResponse(url, data, result) {
        var res = JSON.parse(result);

        if (res.errCode != "success") {
            alert(getLanguage() == 1 ? "更新成功" : "update error");
        }
    }


    $("#addDefaultFriendSwitch").change(function () {

        var userId = $("#user-id").attr("data");
        var isChecked = $(this).is(':checked')

        var url = "index.php?action=manage.user.update&lang=" + getLanguage();

        var data = {
            'userId': userId,
            'key': 'addDefaultFriend',
            'value': isChecked ? 1 : 0,
        };

        zalyjsCommonAjaxPostJson(url, data, addDefaultFriendResponse);
    });

    function addDefaultFriendResponse(url, data, result) {
        var res = JSON.parse(result);

        if (res.errCode != "success") {
            alert(getLanguage() == 1 ? "更新成功" : "update error");
        }
    }


    $("#user-group-list").click(function () {
        var userId = $("#user-id").attr("data");

        var url = "index.php?action=manage.user.groups&userId=" + userId + "&lang=" + getLanguage();

        zalyjsCommonOpenPage(url);
    });


    $("#remove-user").click(function () {
        var userId = $("#user-id").attr("data");

        var url = "index.php?action=manage.user.delete&lang=" + getLanguage();

        var data = {
            'userId': userId
        };

        zalyjsCommonAjaxPostJson(url, data, removeUserResponse);
    });

    function removeUserResponse(url, data, result) {
        var res = JSON.parse(result);

        if (res.errCode == "success") {
            var url = "index.php?action=manage.user&lang=" + getLanguage();
            location.href = url;
        } else {
            alert(getLanguage() == 1 ? "删除用户失败" : "update error");
        }

    }


</script>


</body>
</html>




