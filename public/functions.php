<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type");
header("Access-Control-Allow-Credentials: true");
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

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
    if ($archive->request->getPathInfo() == '/themeOption') {
        getThemeOption($archive);
    }
}

/**
 * 获取主题配置
 */
function getThemeOption($archive)
{
    $db = Typecho_Db::get();
    $options = Helper::options();

    $archive->response->setStatus(200);

    $query = $db->select()->from('table.options')->where(' name = ?', 'theme:icefox-vue');

    $result = $db->fetchAll($query);

    $archive->response->throwJson(array('status' => 1, 'data' => $result));
}