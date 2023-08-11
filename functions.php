<?php
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
    if ($archive->request->getPathInfo() == '/comment') {
        ajaxComment($archive);
    }
}

/**
 * ajaxComment
 * 实现Ajax评论的方法(实现feedback中的comment功能)
 * @param Widget_Archive $archive
 * @return void
 */
function ajaxComment($archive)
{
    $archive->response->setStatus(200);

    $options = Helper::options();
    $user = Typecho_Widget::widget('Widget_User');
    $db = Typecho_Db::get();
    // Security 验证不通过时会直接跳转，所以需要自己进行判断
    // 需要开启反垃圾保护，此时将不验证来源
    $security = $archive->widget("Widget_Security");
    if ($archive->request->get('_') != $security->getToken($archive->request->getReferer())) {
        $archive->response->throwJson(array('status' => 0, 'msg' => _t('非法请求')));
    }
    /** 评论关闭 */
//    print_r($archive);
//    print_r('----------------------');
//    if (!$archive->allow('comment')) {
//        $archive->response->throwJson(array('status' => 0, 'msg' => _t('评论已关闭'), 'comment' => $archive));
//    }
    /** 检查ip评论间隔 */
    if (!$user->pass('editor', true) && $archive->authorId != $user->uid &&
        $options->commentsPostIntervalEnable) {
        $latestComment = $db->fetchRow($db->select('created')->from('table.comments')
            ->where('cid = ?', $archive->cid)
            ->where('ip = ?', $archive->request->getIp())
            ->order('created', Typecho_Db::SORT_DESC)
            ->limit(1));

        if ($latestComment && ($options->gmtTime - $latestComment['created'] > 0 &&
                $options->gmtTime - $latestComment['created'] < $options->commentsPostInterval)) {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('对不起, 您的发言过于频繁, 请稍侯再次发布')));
        }
    }

    $comment = array(
        'cid' => $archive->request->cid,
        'created' => $options->gmtTime,
        'agent' => $archive->request->getAgent(),
        'ip' => $archive->request->getIp(),
        'ownerId' => $archive->author->uid,
        'type' => 'comment',
        'status' => !$archive->allow('edit') && $options->commentsRequireModeration ? 'waiting' : 'approved'
    );

    /** 判断父节点 */
    if ($parentId = $archive->request->filter('int')->get('parent')) {
        if ($options->commentsThreaded && ($parent = $db->fetchRow($db->select('coid', 'cid')->from('table.comments')
                ->where('coid = ?', $parentId))) && $archive->cid == $parent['cid']) {
            $comment['parent'] = $parentId;
        } else {
            $archive->response->throwJson(array('status' => 0, 'msg' => _t('父级评论不存在')));
        }
    }

    $feedback = Typecho_Widget::widget('Widget_Feedback');
    //检验格式
    $validator = new Typecho_Validate();
    $validator->addRule('author', 'required', _t('必须填写用户名'));
    $validator->addRule('author', 'xssCheck', _t('请不要在用户名中使用特殊字符'));
    $validator->addRule('author', array($feedback, 'requireUserLogin'), _t('您所使用的用户名已经被注册,请登录后再次提交'));
    $validator->addRule('author', 'maxLength', _t('用户名最多包含200个字符'), 200);


    if ($options->commentsRequireMail && !$user->hasLogin()) {
        $validator->addRule('mail', 'required', _t('必须填写电子邮箱地址'));
    }

    $validator->addRule('mail', 'email', _t('邮箱地址不合法'));
    $validator->addRule('mail', 'maxLength', _t('电子邮箱最多包含200个字符'), 200);

    if ($options->commentsRequireUrl && !$user->hasLogin()) {
        $validator->addRule('url', 'required', _t('必须填写个人主页'));
    }
    $validator->addRule('url', 'required', _t('必须填写个人主页地址'));
    $validator->addRule('url', 'url', _t('个人主页地址格式错误'));
    $validator->addRule('url', 'maxLength', _t('个人主页地址最多包含200个字符'), 200);

    $validator->addRule('text', 'required', _t('必须填写评论内容'));

    $comment['text'] = $archive->request->text;

    /** 对一般匿名访问者,将用户数据保存一个月 */
    if (!$user->hasLogin()) {
        /** Anti-XSS */
        $comment['author'] = $archive->request->filter('trim')->author;
        $comment['mail'] = $archive->request->filter('trim')->mail;
        $comment['url'] = $archive->request->filter('trim')->url;

        /** 修正用户提交的url */
        if (!empty($comment['url'])) {
            $urlParams = parse_url($comment['url']);
            if (!isset($urlParams['scheme'])) {
                $comment['url'] = 'http://' . $comment['url'];
            }
        }

        $expire = $options->gmtTime + $options->timezone + 30 * 24 * 3600;
        Typecho_Cookie::set('__typecho_remember_author', $comment['author'], $expire);
        Typecho_Cookie::set('__typecho_remember_mail', $comment['mail'], $expire);
        Typecho_Cookie::set('__typecho_remember_url', $comment['url'], $expire);
    } else {
        $comment['author'] = $user->screenName;
        $comment['mail'] = $user->mail;
        $comment['url'] = $user->url;

        /** 记录登录用户的id */
        $comment['authorId'] = $user->uid;
    }

    /** 评论者之前须有评论通过了审核 */
    if (!$options->commentsRequireModeration && $options->commentsWhitelist) {
        if ($feedback->size($feedback->select()->where('author = ? AND mail = ? AND status = ?', $comment['author'], $comment['mail'], 'approved'))) {
            $comment['status'] = 'approved';
        } else {
            $comment['status'] = 'waiting';
        }
    }

    if ($error = $validator->run($comment)) {
        $archive->response->throwJson(array('status' => 0, 'msg' => implode(';', $error)));
    }

    /** 添加评论 */
    $commentId = $feedback->insert($comment);
    if (!$commentId) {
        $archive->response->throwJson(array('status' => 0, 'msg' => _t('评论失败')));
    }

    Typecho_Cookie::delete('__typecho_remember_text');


    $db->fetchRow($feedback->select()->where('coid = ?', $commentId)
        ->limit(1), array($feedback, 'push'));

    // 返回评论数据
//    $data = array(
//        //'cid' => $feedback->cid,
//        'cid' => 57,
//        'coid' => $feedback->coid,
//        'parent' => $feedback->parent,
//        'mail' => $feedback->mail,
//        'url' => $feedback->url,
//        'ip' => $feedback->ip,
//        'agent' => $feedback->agent,
//        'author' => $feedback->author,
//        'authorId' => $feedback->authorId,
//        'permalink' => $feedback->permalink,
//        'created' => $feedback->created,
//        'datetime' => $feedback->date->format('Y-m-d H:i:s'),
//        'status' => $feedback->status,
//    );
    // 评论内容
    ob_start();
//    $feedback->content();
    //$data['content'] = ob_get_clean();

    //$data['avatar'] = Typecho_Common::gravatarUrl($data['mail'], 48, Helper::options()->commentsAvatarRating, NULL, $archive->request->isSecure());

    $archive->response->throwJson(array('status' => 1));
}

// 获取评论信息
function articleComment($article_id)
{
    $db = Typecho_Db::get();
    $query = $db->select('author', 'text', 'url', 'coid')->from('table.comments')->where('cid = ?', $article_id);
    $result = $db->fetchAll($query);

    $query = $db->select('author', 'text', 'url')->from('table.comments')->where('cid = ?', $article_id);
    $counter = $db->fetchAll($query);

    foreach ($result as $val) {
//        echo '
//        <div class="comment-item">
//            <a href="' . $val['url'] . '" target="_black">' . $val['author'] . '</a>： <span class="f-thide">' . get_commentReply_at($val['coid']) . ' ' . $val['text'] . '</span>
//        </div>';
        echo ' <div>
                   <a href="' . $val['url'] . '"><span class="text-[#576b95]">'.$val['author'].'</span></a><span>: ' . $val['text'] . '</span>
              </div>';
    }
}

//评论添加回复@标记
function get_commentReply_at($coid)
{
    $db = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent')->from('table.comments')
        ->where('coid = ? AND status = ?', $coid, 'approved'));
    $parent = $prow['parent'];
    if ($parent != "0") {
        $arow = $db->fetchRow($db->select('author')->from('table.comments')
            ->where('coid = ? AND status = ?', $parent, 'approved'));
        $author = $arow['author'];
        $href = '@' . $author . ': ';
        return $href;
    }
}