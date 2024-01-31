<?php

use Typecho\Common;
use Widget\Options;
use Widget\Notice;

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

//icefox 核心包
include_once 'core/core.php';

function themeConfig($form)
{
    ?>
    <link rel="stylesheet" href="/usr/themes/icefox/assets/admin.css">
    <div>
        <div class="admin-title">Icefox主题后台配置（v1.3.0）</div>
        <div>
            <div>
                <?php
                $backgroundImageUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    'backgroundImageUrl',
                    null,
                    null,
                    _t('站点顶部背景图'),
                    _t('在这里填入一个图片 URL 地址, 以在站点顶部显示该图片')
                );

                $form->addInput($backgroundImageUrl);

                $userAvatarUrl = new Typecho_Widget_Helper_Form_Element_Text(
                    'userAvatarUrl',
                    null,
                    null,
                    _t('用户头像'),
                    _t('在这里填入一个图片 URL 地址')
                );

                $form->addInput($userAvatarUrl);

                $topPost = new Typecho_Widget_Helper_Form_Element_Text(
                    "topPost",
                    null,
                    null,
                    "置顶文章",
                    "格式：文章的ID,文章的ID,文章的ID （中间使用英文逗号,分隔）"
                );
                $form->addInput($topPost);

                $beian = new Typecho_Widget_Helper_Form_Element_Text(
                    "beian",
                    null,
                    null,
                    "备案号",
                    "例如：京ICP备00000001号"
                );
                $form->addInput($beian);

                $autoPlayVideo = new Typecho_Widget_Helper_Form_Element_Radio(
                    'autoPlayVideo',
                    [
                        'yes' => _t("是"),
                        'no' => _t("否")
                    ],
                    'yes',
                    _t('是否默认播放视频')
                );
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
                $form->addInput($autoMutedPlayVideo);

                $script = new Typecho_Widget_Helper_Form_Element_Textarea(
                    "script",
                    null,
                    null,
                    "全局自定义JavaScript",
                    "不用添加script标签"
                );
                $form->addInput($script);

                $css = new Typecho_Widget_Helper_Form_Element_Textarea(
                    "css",
                    null,
                    null,
                    "全局自定义CSS",
                    "不用添加style标签"
                );
                $form->addInput($css);

                ?>
            </div>
        </div>
    </div>

    <?php


    // backupThemeData();
}

function themeFields($layout)
{
    $friendVideo = new Typecho_Widget_Helper_Form_Element_Textarea(
        'friend_video',
        null,
        null,
        _t('朋友圈视频'),
        _t('<span style="color:red;">在这里填入朋友圈视频地址</span>')
    );
    $layout->addItem($friendVideo);

    $friendPicture = new Typecho_Widget_Helper_Form_Element_Textarea(
        'friend_pictures',
        null,
        null,
        _t('朋友圈图片'),
        _t('<span style="color:red;">在这里填入朋友圈图片，最多9张，使用英文逗号隔开（注：如果填了朋友圈视频，则优先视频）</span>')
    );
    $layout->addItem($friendPicture);

    $position = new Typecho_Widget_Helper_Form_Element_Text(
        'position',
        null,
        null,
        _t('发布定位'),
        _t('<span style="color:red;">在这里填定位名称（例：成都市·天府广场）</span>')
    );
    $layout->addItem($position);

    $isAdvertise = new Typecho_Widget_Helper_Form_Element_Radio(
        "isAdvertise",
        [
            "1" => _t("是"),
            "0" => _t("不是"),
        ],
        "0",
        _t("是否是广告"),
        _t('<span style="color:red;">默认不是</span>')
    );
    $layout->addItem($isAdvertise);

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

/**
 * 备份主题数据
 * @return void
 */
function backupThemeData()
{
    $name = "icefox";
    $db = Typecho_Db::get();
    if (isset($_POST["type"])) {

        if ($_POST["type"] == "创建备份") {
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
                Notice::alloc()->set("备份更新成功", "success");
                Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
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
                    Notice::alloc()->set("备份成功", "success");
                    Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
                ?>
                <?php
                }
            }
        }
        if ($_POST["type"] == "还原备份") {
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
                Notice::alloc()->set("备份还原成功", "success");
                Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
            ?>
            <?php
            } else {

                Notice::alloc()->set("无备份数据，请先创建备份", "error");
                Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
            ?>
            <?php
            } ?>
        <?php
        }
        ?>
        <?php if ($_POST["type"] == "删除备份") {
            if (
                $db->fetchRow(
                    $db
                        ->select()
                        ->from("table.options")
                        ->where("name = ?", "theme:" . $name . "_backup")
                )
            ) {

                $db->query($db->delete("table.options")->where("name = ?", "theme:" . $name . "_backup"));
                Notice::alloc()->set("删除备份成功", "success");
                Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
            ?>
            <?php
            } else {

                Notice::alloc()->set("无备份数据，无法删除", "success");
                Options::alloc()->response->redirect(Common::url("options-theme.php", Options::alloc()->adminUrl));
            ?>
            <?php
            } ?>
        <?php
        } ?>
    <?php
    }
    ?>

    </form>
    <?php echo '<br/><div class="message error">请先点击右下角的保存设置按钮，创建备份！<br/><br/><form class="backup" action="?calm_backup" method="post">
    <input type="submit" name="type" class="btn primary" value="创建备份" />
    <input type="submit" name="type" class="btn primary" value="还原备份" />
    <input type="submit" name="type" class="btn primary" value="删除备份" /></form></div>';
}