<?php

use Typecho\Common;

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

// 设置版本号
if (!defined("__THEME_VERSION__")) {
    define("__THEME_VERSION__", "2.2.0");
}

// 设置默认头像源为https://cravatar.cn/avatar/
// define('__TYPECHO_GRAVATAR_PREFIX__', 'https://cravatar.cn/avatar/');

//icefox 核心包
include_once 'core/core.php';

function themeConfig($form)
{
    ?>
    <link rel="stylesheet" href="/usr/themes/icefox/assets/css/admin.css">
    <script src="/usr/themes/icefox/assets/js/jquery.min.js"></script>
    <script src="/usr/themes/icefox/assets/js/admin.js"></script>
    <div class="icefox-config">
        <div class="flex flex-row">
            <div class="icefox-nav">
                    <div class="icefox-nav-title">icefox(v<?php echo __THEME_VERSION__; ?>)</div>
                    <div class="icefox-nav-sub-title"><a href="https://xiaopanglian.com/">作者：小胖脸</a></div>
                    <?php
                    backupThemeData();
                    ?>
                <div>
                    <ul class="icefox-nav-ul">
                        <li class="icefox-global active" data-type="global">全局设置</li>
                        <li class="icefox-home" data-type="home">顶部设置</li>
                        <li class="icefox-media" data-type="media">媒体设置</li>
                        <li class="icefox-advertise" data-type="advertise">广告设置</li>
                        <li class="icefox-page" data-type="page">页面设置</li>
                        <li class="icefox-friend" data-type="friend">友联设置</li>
                        <li class="icefox-other" data-type="other">其他设置</li>
                    </ul>
                </div>
            </div>
                <?php
                $backgroundImageUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    'backgroundImageUrl',
                    null,
                    null,
                    _t('站点顶部背景图'),
                    _t('在这里填入一个图片 URL 地址, 以在站点顶部显示该图片')
                );
                $backgroundImageUrl->setAttribute('class', 'icefox-content icefox-home');
                $form->addInput($backgroundImageUrl);

                $userAvatarUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    'userAvatarUrl',
                    null,
                    null,
                    _t('站点顶部用户头像'),
                    _t('在这里填入一个图片 URL 地址')
                );

                $userAvatarUrl->setAttribute('class', 'icefox-content icefox-home');
                $form->addInput($userAvatarUrl);

                $archiveUserAvatarUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    'archiveUserAvatarUrl',
                    null,
                    null,
                    _t('文章侧用户头像<span style="color:red;">(如果不设置，默认使用头像源地址的头像)</span>'),
                    _t('在这里填入一个图片 URL 地址')
                );

                $archiveUserAvatarUrl->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($archiveUserAvatarUrl);

                $avatarTitle = new Typecho_Widget_Helper_Form_Element_Text(
                    'avatarTitle',
                    null,
                    null,
                    _t('顶部用户头像旁名称'),
                    _t('在这里填入顶部用户头像旁展示的名称')
                );

                $avatarTitle->setAttribute('class', 'icefox-content icefox-home');
                $form->addInput($avatarTitle);

                $about = new Typecho_Widget_Helper_Form_Element_Text(
                    'about',
                    null,
                    null,
                    _t('顶部头像旁名称跳转地址'),
                    _t('顶部头像旁名称跳转地址')
                );
                $about->setAttribute('class', 'icefox-content icefox-home');
                $form->addInput($about);

                $topPost = new Typecho_Widget_Helper_Form_Element_Text(
                    "topPost",
                    null,
                    null,
                    "置顶文章",
                    "格式：文章的ID || 文章的ID || 文章的ID （中间使用 || 分隔）"
                );
                $topPost->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($topPost);

                $beian = new Typecho_Widget_Helper_Form_Element_Text(
                    "beian",
                    null,
                    null,
                    "备案号",
                    "例如：京ICP备00000001号"
                );
                $beian->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($beian);

                $policeBeian = new Typecho_Widget_Helper_Form_Element_Text(
                    "policeBeian",
                    null,
                    null,
                    "公安网备号",
                    "网备号和跳转地址通过||分隔开<br>例如：川公安网备000000001号 || http://www.beian.gov.cn/portal/registerSystemInfo?recordcode=00000001"
                );
                $policeBeian->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($policeBeian);

                $observAutoPlayVideo = new Typecho_Widget_Helper_Form_Element_Radio(
                    'observAutoPlayVideo',
                    [
                        'yes' => _t("是"),
                        'no' => _t("否")
                    ],
                    'yes',
                    _t('是否开启可视范围内视频自动播放'),
                    _t('默认开启')
                );
                $observAutoPlayVideo->setAttribute('class', 'icefox-content icefox-media');
                $form->addInput($observAutoPlayVideo);

                $autoPlayVideo = new Typecho_Widget_Helper_Form_Element_Radio(
                    'autoPlayVideo',
                    [
                        'yes' => _t("是"),
                        'no' => _t("否")
                    ],
                    'yes',
                    _t('是否默认播放视频<span style="color:red;">（开启可视范围内自动播放功能后，此功能失效）</span>')
                );
                $autoPlayVideo->setAttribute('class', 'icefox-content icefox-media');
                $form->addInput($autoPlayVideo);

                $autoMutedPlayVideo = new Typecho_Widget_Helper_Form_Element_Radio(
                    'autoMutedPlayVideo',
                    [
                        'yes' => _t("是"),
                        'no' => _t("否")
                    ],
                    'yes',
                    _t('是否默认静音播放视频')
                );
                $autoMutedPlayVideo->setAttribute('class', 'icefox-content icefox-media');
                $form->addInput($autoMutedPlayVideo);

                $avatarSource = new Typecho_Widget_Helper_Form_Element_Text(
                    "avatarSource",
                    null,
                    null,
                    "主题左侧头像源",
                    "不填则默认为https://cravatar.cn/avatar/"
                );
                $avatarSource->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($avatarSource);

                $defaultThemeColor = new Typecho_Widget_Helper_Form_Element_Radio(
                    'defaultThemeColor',
                    [
                        'yes' => _t("暗色"),
                        'no' => _t("亮色")
                    ],
                    'yes',
                    _t('默认主题配色')
                );
                $defaultThemeColor->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($defaultThemeColor);

//                $enableTopMusic = new Typecho_Widget_Helper_Form_Element_Radio(
//                    'enableTopMusic',
//                    [
//                        'yes' => _t("是"),
//                        'no' => _t("否")
//                    ],
//                    'yes',
//                    _t('是否启用顶部网易云音乐')
//                );
//                $enableTopMusic->setAttribute('class', 'icefox-content icefox-media');
//                $form->addInput($enableTopMusic);

//                $topMusicList = new Typecho_Widget_Helper_Form_Element_Textarea(
//                    'topMusicList',
//                    null,
//                    null,
//                    _t('顶部网易云音乐歌曲列表'),
//                    _t('网页顶部播放器播放，每一行一首歌，格式如下<br>网易云音乐id || 音乐封面图')
//                );
//                $topMusicList->setAttribute('class', 'icefox-content icefox-media');
//                $form->addInput($topMusicList);

                $friendLinks = new Typecho_Widget_Helper_Form_Element_Textarea(
                    "friendLinks",
                    null,
                    null,
                    "友情链接",
                    "使用||分隔，每一行一个友情链接。格式如下<br>logo || 名称 || 链接"
                );
                $friendLinks->setAttribute('class', 'icefox-content icefox-friend');
                $form->addInput($friendLinks);

                $publishPageUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    "publishPageUrl",
                    null,
                    null,
                    "前端发布页地址",
                    "后台新建独立页面地址对应页面"
                );
                $publishPageUrl->setAttribute('class', 'icefox-content icefox-page');
                $form->addInput($publishPageUrl);

                $script = new Typecho_Widget_Helper_Form_Element_Textarea(
                    "script",
                    null,
                    null,
                    "全局自定义JavaScript",
                    "不用添加script标签"
                );
                $script->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($script);

                $css = new Typecho_Widget_Helper_Form_Element_Textarea(
                    "css",
                    null,
                    null,
                    "全局自定义CSS",
                    "不用添加style标签"
                );
                $css->setAttribute('class', 'icefox-content icefox-global');
                $form->addInput($css);
                $form->setAttribute('class', 'icefox-config-form');

                ?>
    <?php


}

function themeFields($layout)
{
    ?>
    <style>
        textarea {
            width: 100%;
            height: 8rem;
        }

        input[type=text] {
            width: 100%;
        }
    </style>
    <?php
    $friendVideo = new Typecho_Widget_Helper_Form_Element_Textarea(
        'friend_video',
        null,
        null,
        _t('朋友圈视频'),
        _t('<span>在这里填入朋友圈视频地址</span>')
    );
    $friendVideo->input->setAttribute('class', 't-video-find friend_video_input');
    $layout->addItem($friendVideo);

    $friendPicture = new Typecho_Widget_Helper_Form_Element_Textarea(
        'friend_pictures',
        null,
        null,
        _t('朋友圈图片'),
        _t('<span style="color:red;">不推荐，最好直接把图片添加在文章内容里面</span><br><span>在这里填入朋友圈图片，最多9张，使用英文逗号隔开（注：如果填了朋友圈视频，则优先视频）</span>')
    );
    $friendPicture->input->setAttribute('class', 't-default-find');
    $layout->addItem($friendPicture);

    $position = new Typecho_Widget_Helper_Form_Element_Text(
        'position',
        null,
        null,
        _t('发布定位'),
        _t('<span>在这里填定位名称（例：成都市·天府广场）</span>')
    );
    $position->input->setAttribute('class', 't-default-find');
    $layout->addItem($position);

    $positionUrl = new Typecho_Widget_Helper_Form_Element_Text(
        'positionUrl',
        null,
        null,
        _t('定位跳转地址')
    );
    $positionUrl->input->setAttribute('class', 't-default-find');
    $layout->addItem($positionUrl);

    $isAdvertise = new Typecho_Widget_Helper_Form_Element_Radio(
        "isAdvertise",
        [
            "1" => _t("是"),
            "0" => _t("不是"),
        ],
        "0",
        _t("是否是广告"),
        _t('<span>默认不是</span>')
    );
    $isAdvertise->input->setAttribute('class', 't-default-find');
    $layout->addItem($isAdvertise);

    $music = new Typecho_Widget_Helper_Form_Element_Textarea(
        'music',
        null,
        null,
        _t('插入音乐'),
        _t('为兼容历史音乐，这里需要填入完整的播放地址，如果是网易云音乐，播放地址是：http://music.163.com/song/media/outer/url?id=xxxxxx.mp3，最后的xxxxxx替换为网易云音乐id。插入音乐格式如下：<br>歌曲名称 || 专辑名称 || 播放地址 || 音乐图片')
    );
    $music->input->setAttribute('class', 't-music-find');
    $layout->addItem($music);

    // $canComment = new Typecho_Widget_Helper_Form_Element_Radio(
    //     "canComment",
    //     [
    //         "1" => _t("允许"),
    //         "0" => _t("不允许"),
    //     ],
    //     "1",
    //     _t("是否允许评论"),
    //     _t('<span style="color:red;">默认允许评论</span>')
    // );
    // $layout->addItem($canComment);
}

//自定义字段扩展
Typecho_Plugin::factory('admin/write-post.php')->bottom = array('tabField', 'tabs');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('tabField', 'tabs');

class tabField
{
    public static function tabs()
    {
        ?>
        <style>
            .tabss {
                margin: 10px;
                clear: both;
                display: block;
                height: 30px;
                padding: 0
            }

            ;

            .tabss a {
                outline: none !important
            }

            ;
        </style>

        <script>
            $(function () {
                var tabsHtml = `
                                                                            <ul class="typecho-option-tabs tabss" style="">
                                                                                <li class="current" id="t-default"><a href="javascript:;">默认</a></li>
                                                                                <li class="" id="t-video"><a href="javascript:;">视频</a></li>
                                                                                <li class="" id="t-music"><a href="javascript:;">音乐</a></li>
                                                                            </ul>`;
                $("#custom-field-expand").after(tabsHtml);

                //初始化，全部隐藏
                $("#custom-field>table>tbody").find("tr").hide();

                //初始化显示
                $(".tabss>li.current").parent().siblings("table").find('.t-default-find').closest('tr').show();

                $(".tabss li").click(function () {
                    var clasz = this.id;
                    //删除同胞的current
                    $(this).siblings().removeClass('current');
                    //自身添加current
                    $(this).addClass('current');
                    //全部隐藏
                    $("#custom-field>table>tbody").find("tr").hide();
                    //显示自身底下的子元素
                    $(".tabss>li.current").parent().siblings("table").find('.' + clasz + '-find').closest('tr').show();
                });
            });
        </script>
        <?php
    }
}

/**
 * 备份主题数据
 * @return void
 */
function backupThemeData()
{
    $name = "icefox";
    $db = Typecho_Db::get();
    if (isset($_POST["type"])) {

        if ($_POST["type"] == "备份") {
            $value = $db->fetchRow(
                $db
                    ->select()
                    ->from("table.options")
                    ->where("name = ?", "theme:" . $name)
            )["value"];
            if (
                $db->fetchRow(
                    $db
                        ->select()
                        ->from("table.options")
                        ->where("name = ?", "theme:" . $name . "_backup")
                )
            ) {

                $db->query(
                    $db
                        ->update("table.options")
                        ->rows(["value" => $value])
                        ->where("name = ?", "theme:" . $name . "_backup")
                );
                try {
                    Widget_Notice::alloc()->set("备份更新成功", "success");
                    Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                } catch (Exception $exception) {
                }
                ?>
                <?php
            } else {
                ?>
                <?php if ($value) {

                    $db->query(
                        $db
                            ->insert("table.options")
                            ->rows(["name" => "theme:" . $name . "_backup", "user" => "0", "value" => $value])
                    );
                    try {
                        Widget_Notice::alloc()->set("备份成功", "success");
                        Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                    } catch (Exception $exception) {
                    }
                    ?>
                    <?php
                }
            }
        }
        if ($_POST["type"] == "还原") {
            if (
                $db->fetchRow(
                    $db
                        ->select()
                        ->from("table.options")
                        ->where("name = ?", "theme:" . $name . "_backup")
                )
            ) {

                $_value = $db->fetchRow(
                    $db
                        ->select()
                        ->from("table.options")
                        ->where("name = ?", "theme:" . $name . "_backup")
                )["value"];
                $db->query(
                    $db
                        ->update("table.options")
                        ->rows(["value" => $_value])
                        ->where("name = ?", "theme:" . $name)
                );
                try {
                    Widget_Notice::alloc()->set("备份还原成功", "success");
                    Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                } catch (Exception $exception) {
                }
                ?>
                <?php
            } else {

                try {
                    Widget_Notice::alloc()->set("无备份数据，请先创建备份", "error");
                    Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                } catch (Exception $exception) {
                }
                ?>
                <?php
            } ?>
            <?php
        }
        ?>
        <?php if ($_POST["type"] == "删除") {
            if (
                $db->fetchRow(
                    $db
                        ->select()
                        ->from("table.options")
                        ->where("name = ?", "theme:" . $name . "_backup")
                )
            ) {

                $db->query($db->delete("table.options")->where("name = ?", "theme:" . $name . "_backup"));
                try {
                    Widget_Notice::alloc()->set("删除备份成功", "success");
                    Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                } catch (Exception $exception) {
                }
                ?>
                <?php
            } else {

                try {
                    Widget_Notice::alloc()->set("无备份数据，无法删除", "success");
                    Widget_Options::alloc()->response->redirect(Common::url("options-theme.php", Widget_Options::alloc()->adminUrl));
                } catch (Exception $exception) {
                }
                ?>
                <?php
            } ?>
            <?php
        } ?>
        <?php
    }
    ?>

    </form>
    <?php echo '<div class="icefox-nav-backup">请先点击右下角的保存设置按钮，再创建备份！<br/><br/><form class="backup" action="?calm_backup" method="post">
    <input type="submit" name="type" class="btn primary" value="备份" />
    <input type="submit" name="type" class="btn primary" value="还原" />
    <input type="submit" name="type" class="btn primary" value="删除" /></form></div>';
}