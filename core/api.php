<?php

/**
 * 添加评论
 */
function addComment($self)
{
    $self->response->setStatus(200);
    $options = Helper::options();
    $user = Typecho_Widget::widget('Widget_User');
    $db = Typecho_Db::get();

    // // Security 验证不通过时会直接跳转，所以需要自己进行判断
    // // 需要开启反垃圾保护，此时将不验证来源
    // if ($self->request->get('_') != Helper::security()->getToken($self->request->getReferer())) {
    //     $self->response->throwJson(array('status' => 0, 'msg' => _t('非法请求')));
    // }

    /** 检查ip评论间隔 */
    if (!$user->pass('editor', true) && $self->authorId != $user->uid && $options->commentsPostIntervalEnable) {
        $latestComment = $db->fetchRow($db->select('created')->from('table.comments')
            ->where('cid = ?', $self->request->cid)
            ->where('ip = ?', $self->request->getIp())
            ->order('created', Typecho_Db::SORT_DESC)
            ->limit(1));

        if ($latestComment && ($options->gmtTime - $latestComment['created'] > 0 && $options->gmtTime - $latestComment['created'] < $options->commentsPostInterval)) {
            $self->response->throwJson(array('status' => 0, 'msg' => _t('对不起, 您的发言过于频繁, 请稍侯再次发布')));
        }
    }

    $comment = array(
        'cid' => $self->request->cid,
        'created' => $options->gmtTime,
        'agent' => $self->request->getAgent(),
        'ip' => $self->request->getIp(),
        'ownerId' => 1,
        'type' => 'comment',
        'status' => $options->commentsRequireModeration ? 'waiting' : 'approved'
    );

    /** 判断父节点 */
    if ($parentId = $self->request->filter('int')->get('parent')) {
        if ($options->commentsThreaded && ($parent = $db->fetchRow($db->select('coid', 'cid')->from('table.comments')->where('coid = ?', $parentId))) && $self->request->cid == $parent['cid']) {
            $comment['parent'] = $parentId;
        } else {
            $self->response->throwJson(array('status' => 0, 'msg' => _t('父级评论不存在')));
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

    if ($options->commentsRequireURL && !$user->hasLogin()) {
        $validator->addRule('url', 'required', _t('必须填写个人主页'));
    }
    $validator->addRule('url', 'url', _t('个人主页地址格式错误'));
    $validator->addRule('url', 'maxLength', _t('个人主页地址最多包含200个字符'), 200);

    $validator->addRule('text', 'required', _t('必须填写评论内容'));

    $comment['text'] = $self->request->text;

    /** 对一般匿名访问者,将用户数据保存一个月 */

    if (!$user->hasLogin()) {
        /** Anti-XSS */
        $comment['author'] = $self->request->filter('trim')->author;
        $comment['mail'] = $self->request->filter('trim')->mail;
        $comment['url'] = $self->request->filter('trim')->url;

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

    /** 如果系统设置为不需要审核，并且评论者之前须有评论通过了审核 */
    if (!$options->commentsRequireModeration && $options->commentsWhitelist) {
        if ($feedback->size($feedback->select()->where('author = ? AND mail = ? AND status = ?', $comment['author'], $comment['mail'], 'approved'))) {
            $comment['status'] = 'approved'; // 评论者之前有评论通过了审核设置为审核通过
        } else {
            $comment['status'] = 'waiting'; //  没有的话评论设置为待审核
        }
    }

    if ($error = $validator->run($comment)) {
        $self->response->throwJson(array('status' => 0, 'msg' => implode(';', $error)));
    }

    /** 添加评论 */
    $commentId = $feedback->insert($comment);
    if (!$commentId) {
        $self->response->throwJson(array('status' => 0, 'msg' => _t('评论失败')));
    }
    Typecho_Cookie::delete('__typecho_remember_text');
    $db->fetchRow($feedback->select()->where('coid = ?', $commentId)
        ->limit(1), array($feedback, 'push'));
    // 返回评论数据
    $data = array(
        'cid' => $feedback->cid,
        'coid' => $feedback->coid,
        'parent' => $feedback->parent,
        'mail' => $feedback->mail,
        'url' => $feedback->url,
        'ip' => $feedback->ip,
        'agent' => $feedback->agent,
        'author' => $feedback->author,
        'authorId' => $feedback->authorId,
        'permalink' => $feedback->permalink,
        'created' => $feedback->created,
        'datetime' => $feedback->date->format('Y-m-d H:i:s'),
        'status' => $feedback->status,
    );
    // 评论内容
    ob_start();
    $feedback->content();
    $data['content'] = ob_get_clean();

    $data['avatar'] = Typecho_Common::gravatarUrl($data['mail'], 48, Helper::options()->commentsAvatarRating, NULL, $self->request->isSecure());
    $self->response->throwJson(array('status' => 1, 'comment' => $data));
}

/**
 * 点赞
 */
function addAgree($self)
{
    $self->response->setStatus(200);

    $cid = $self->request->cid;
    $isAgree = $self->request->agree;

    $db = Typecho_Db::get();
    //  根据文章的 `cid` 查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));

    //  获取点赞记录的 Cookie
    $agreeRecording = Typecho_Cookie::get('typechoAgreeRecording');

    $num = 1;

    //  判断 Cookie 是否存在
    if (empty($agreeRecording)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('typechoAgreeRecording', json_encode(array($cid)));

    } else {
        // 点赞
        if ($isAgree == 1) {
            //  把 Cookie 的 JSON 字符串转换为 PHP 对象
            $agreeRecording = json_decode($agreeRecording);
            //  判断文章是否点赞过
            if (in_array($cid, $agreeRecording)) {
                //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
                return $self->response->throwJson(array('status' => 1, 'agree' => $agree['agree']));
            }
            //  添加点赞文章的 cid
            array_push($agreeRecording, $cid);
            //  保存 Cookie
            Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
        } else {
            // 取消点赞
            //  把 Cookie 的 JSON 字符串转换为 PHP 对象
            $agreeRecording = json_decode($agreeRecording);
            //  判断文章是否点赞过
            if (!in_array($cid, $agreeRecording)) {
                //  如果当前文章的 cid 不在 cookie 中就返回文章的赞数，不再往下执行
                return $self->response->throwJson(array('status' => 1, 'agree' => $agree['agree']));
            }

            $num = -1;

            //  移除点赞文章的 cid
            $agreeRecording = array_diff($agreeRecording, [$cid]);

            //  保存 Cookie
            Typecho_Cookie::set('typechoAgreeRecording', json_encode($agreeRecording));
        }
    }

    //  更新点赞字段，让点赞字段 +1

    if ($agree['agree'] == 0 && $num < 0) {
        return $self->response->throwJson(array('status' => 1, 'agree' => 0));
    }
    $db->query($db->update('table.contents')->rows(array('agree' => (int) $agree['agree'] + $num))->where('cid = ?', $cid));
    //  查询出点赞数量
    $agree = $db->fetchRow($db->select('table.contents.agree')->from('table.contents')->where('cid = ?', $cid));
    //  返回点赞数量
    return $self->response->throwJson(array('status' => 1, 'agree' => $agree['agree']));
}
?>