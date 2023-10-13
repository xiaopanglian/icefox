<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Credentials: true");
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

use Typecho\Common;
use Widget\Options;
use Utils\Helper;
use Widget\Notice;

function themeConfig($form)
{
    $backgroundImageUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'backgroundImageUrl',
        null,
        null,
        _t('站点顶部背景图'),
        _t('在这里填入一个图片 URL 地址, 以在站点顶部显示该图片')
    );

    $form->addInput($backgroundImageUrl);

    $avatarUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        'avatarUrl',
        null,
        null,
        _t('个人头像'),
        _t('在这里填入一个图片 URL 地址, 以在站点顶部显示个人头像')
    );

    $form->addInput($avatarUrl);

    $nickName = new \Typecho\Widget\Helper\Form\Element\Text(
        'nickName',
        null,
        null,
        _t('用户昵称'),
        _t('在这里填入用户昵称，展示在朋友圈')
    );

    $form->addInput($nickName);

    //    $sidebarBlock = new \Typecho\Widget\Helper\Form\Element\Checkbox(
    //        'sidebarBlock',
    //        [
    //            'ShowRecentPosts'    => _t('显示最新文章'),
    //            'ShowRecentComments' => _t('显示最近回复'),
    //            'ShowCategory'       => _t('显示分类'),
    //            'ShowArchive'        => _t('显示归档'),
    //            'ShowOther'          => _t('显示其它杂项')
    //        ],
    //        ['ShowRecentPosts', 'ShowRecentComments', 'ShowCategory', 'ShowArchive', 'ShowOther'],
    //        _t('侧边栏显示')
    //    );
    //
    //    $form->addInput($sidebarBlock->multiMode());
    backupThemeData();
}


function themeFields($layout)
{
    $friendPicture = new \Typecho\Widget\Helper\Form\Element\Textarea(
        'friend_pictures',
        null,
        null,
        _t('朋友圈图片'),
        _t('<span style="color:red;">在这里填入朋友圈图片，最多9张，使用英文逗号隔开（注：如果是视频，只能上传一个）</span>')
    );
    $layout->addItem($friendPicture);
}

// 主题初始化
function themeInit($archive)
{
    //    if ($archive->request->getPathInfo() == '/themeOption') {
    //        getThemeOption($archive);
    //    }
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
