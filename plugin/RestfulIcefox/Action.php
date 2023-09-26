<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

class RestfulIcefox_Action extends Typecho_Widget implements Widget_Interface_Do
{
    /**
     * @var Typecho_Config
     */
    private $config;

    /**
     * @var Typecho_Db
     */
    private $db;

    /**
     * @var Widget_Options
     */
    private $options;

    /**
     * @var array
     */
    private $httpParams;

    public function __construct($request, $response, $params = null)
    {
        parent::__construct($request, $response, $params);

        $this->db = Typecho_Db::get();
        $this->options = $this->widget('Widget_Options');
        $this->config = $this->options->plugin('RestfulIcefox');
    }

    /**
     * 获取路由参数
     *
     * @return array
     */
    public static function getRoutes()
    {
        $routes = array();
        $reflectClass = new ReflectionClass(__CLASS__);
        $prefix = defined('__TYPECHO_RESTFUL_PREFIX__') ? __TYPECHO_RESTFUL_PREFIX__ : '/api/';

        foreach ($reflectClass->getMethods(ReflectionMethod::IS_PUBLIC) as $reflectMethod) {
            $methodName = $reflectMethod->getName();

            preg_match('/(.*)Action$/', $methodName, $matches);
            if (isset($matches[1])) {
                array_push(
                    $routes,
                    array(
                        'action' => $matches[0],
                        'name' => 'rest_' . $matches[1],
                        'shortName' => $matches[1],
                        'uri' => $prefix . $matches[1],
                        'description' => trim(
                            str_replace(
                                array('/', '*'),
                                '',
                                substr($reflectMethod->getDocComment(), 0, strpos($reflectMethod->getDocComment(), '@'))
                            )
                        ),
                    )
                );
            }
        }
        return $routes;
    }

    public function execute()
    {
        $this->sendCORS();
        $this->parseRequest();
    }

    public function action()
    {
    }

    /**
     * 发送跨域 HEADER
     *
     * @return void
     */
    private function sendCORS()
    {
        $httpOrigin = $this->request->getServer('HTTP_ORIGIN');
        $allowedHttpOrigins = explode("\n", $this->config->origin);

        if (!$httpOrigin) {
            return;
        }

        if (in_array($httpOrigin, $allowedHttpOrigins)) {
            $this->response->setHeader('Access-Control-Allow-Origin', $httpOrigin);
        }

        if (strtolower($this->request->getServer('REQUEST_METHOD')) == 'options') {
            Typecho_Response::setStatus(204);
            $this->response->setHeader('Access-Control-Allow-Headers', 'Origin, No-Cache, X-Requested-With, If-Modified-Since, Pragma, Last-Modified, Cache-Control, Expires, Content-Type');
            $this->response->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
            exit;
        }
    }

    /**
     * 解析请求参数
     *
     * @return void
     */
    private function parseRequest()
    {
        if ($this->request->isPost()) {
            $data = file_get_contents('php://input');
            $data = json_decode($data, true);
            if (json_last_error() != JSON_ERROR_NONE) {
                $this->throwError('Parse JSON error');
            }
            $this->httpParams = $data;
        }
    }

    /**
     * 获取 GET/POST 参数
     *
     * @param string $key 目标参数的 key
     * @param mixed $default 返回的默认值
     * @return mixed
     */
    private function getParams($key, $default = null)
    {
        if ($this->request->isGet()) {
            return $this->request->get($key, $default);
        }
        if (!isset($this->httpParams[$key])) {
            return $default;
        }
        return $this->httpParams[$key];
    }

    /**
     * 以 JSON 格式返回错误
     *
     * @param string $message 错误信息
     * @param integer $status HTTP 状态码
     * @return void
     */
    private function throwError($message = 'unknown', $status = 400)
    {
        Typecho_Response::setStatus($status);
        $this->response->throwJson(
            array(
                'status' => 'error',
                'message' => $message,
                'data' => null,
            )
        );
    }

    /**
     * 以 JSON 格式响应请求的信息
     *
     * @param mixed $data 要返回给用户的内容
     * @return void
     */
    private function throwData($data)
    {
        $this->response->throwJson(
            array(
                'status' => 'success',
                'message' => '',
                'data' => $data,
            )
        );
    }

    /**
     * 锁定 API 请求方式
     *
     * @param string $method 请求方式 (get/post)
     * @return void
     */
    private function lockMethod($method)
    {
        $method = strtolower($method);
        if (strtolower($this->request->getServer('REQUEST_METHOD')) != $method) {
            $this->throwError('method not allowed', 405);
        }
    }

    /**
     * show errors when accessing a disabled API
     *
     * @param string $route
     * @return void
     */
    private function checkState($route)
    {
        $state = $this->config->$route;
        if (!$state) {
            $this->throwError('This API has been disabled.', 403);
        }
    }

    /**
     * 获取文章自定义字段内容
     *
     * @param int $cid
     * @return array
     */
    public function getCustomFields($cid)
    {
        $cfg = $this->config->fieldsPrivacy;
        $filters = empty($cfg) ? array() : explode(',', $cfg);

        $query = $this->db->select('*')->from('table.fields')
            ->where('cid = ?', $cid);
        $rows = $this->db->fetchAll($query);
        $result = array();
        if (count($rows) > 0) {
            foreach ($rows as $key => $value) {
                if (in_array($value['name'], $filters)) {
                    continue;
                }
                $type = $value['type'];
                $result[$value['name']] = array(
                    "name" => $value['name'],
                    "type" => $value['type'],
                    "value" => $value[$value['type'] . '_value'],
                );
            }
        }
        return $result;
    }

    /**
     * 获取文章列表、搜索文章的接口
     *
     * @return void
     */
    public function postsAction()
    {
        $this->lockMethod('get');
        $this->checkState('posts');

        $pageSize = $this->getParams('pageSize', 5);
        $page = $this->getParams('page', 1);
        $page = is_numeric($page) ? $page : 1;
        $offset = $pageSize * ($page - 1);

        $filterType = trim($this->getParams('filterType', ''));
        $filterSlug = trim($this->getParams('filterSlug', ''));
        $showContent = trim($this->getParams('showContent', '')) === 'true';

        if (in_array($filterType, array('category', 'tag', 'search'))) {
            if ($filterSlug == '') {
                $this->throwError('filter slug is empty');
            }

            if ($filterType != 'search') {
                $select = $this->db->select('mid')
                    ->from('table.metas')
                    ->where('type = ?', $filterType)
                    ->where('slug = ?', $filterSlug);

                $row = $this->db->fetchRow($select);
                if (!isset($row['mid'])) {
                    $this->throwError('unknown slug name');
                }
                $mid = $row['mid'];
                $select = $this->db->select('cid')->from('table.relationships')
                    ->where('mid = ?', $mid);

                $cids = $this->db->fetchAll($select);

                if (count($cids) == 0) {
                    $this->throwData(
                        array(
                            'page' => (int) $page,
                            'pageSize' => (int) $pageSize,
                            'pages' => 0,
                            'count' => 0,
                            'dataSet' => array(),
                        )
                    );
                } else {
                    foreach ($cids as $key => $cid) {
                        $cids[$key] = $cids[$key]['cid'];
                    }
                }
            }
        }

        $select = $this->db
            ->select('cid', 'title', 'created', 'modified', 'slug', 'commentsNum', 'text', 'type', 'agree')
            ->from('table.contents')
            ->where('type = ?', 'post')
            ->where('status = ?', 'publish')
            ->where('created < ?', time())
            ->where('password IS NULL')
            ->order('created', Typecho_Db::SORT_DESC);
        if (isset($cids)) {
            $cidStr = implode(',', $cids);
            $select->where('cid IN (' . $cidStr . ')');
        } elseif ($filterType == 'search') {
            // Widget_Archive::searchHandle()
            $searchQuery = '%' . str_replace(' ', '%', $filterSlug) . '%';
            $select->where('title LIKE ? OR text LIKE ?', $searchQuery, $searchQuery);
        }

        $count = count($this->db->fetchAll($select));
        $select->offset($offset)
            ->limit($pageSize);
        $result = $this->db->fetchAll($select);
        foreach ($result as $key => $value) {
            if (!$showContent) {
                unset($result[$key]['text']);
            }
            $result[$key] = $this->filter($result[$key]);
        }

        $this->throwData(
            array(
                'page' => (int) $page,
                'pageSize' => (int) $pageSize,
                'pages' => ceil($count / $pageSize),
                'count' => $count,
                'dataSet' => $result,
            )
        );
    }

    /**
     * 获取页面列表的接口
     *
     * @return void
     */
    public function pagesAction()
    {
        $this->lockMethod('get');
        $this->checkState('pages');

        $select = $this->db
            ->select('cid', 'title', 'created', 'slug')
            ->from('table.contents')
            ->where('type = ?', 'page')
            ->where('status = ?', 'publish')
            ->where('created < ?', time())
            ->where('password IS NULL')
            ->order('order', Typecho_Db::SORT_ASC);

        $result = $this->db->fetchAll($select);
        $count = count($result);

        $this->throwData(
            array(
                'count' => $count,
                'dataSet' => $result,
            )
        );
    }

    /**
     * 获取分类列表的接口
     *
     * @return void
     */
    public function categoriesAction()
    {
        $this->lockMethod('get');
        $this->checkState('categories');
        $categories = $this->widget('Widget_Metas_Category_List');

        if (isset($categories->stack)) {
            $this->throwData($categories->stack);
        } else {
            $reflect = new ReflectionObject($categories);
            $map = $reflect->getProperty('_map');
            $map->setAccessible(true);
            $this->throwData(array_merge($map->getValue($categories)));
        }
    }

    /**
     * 获取标签列表的接口
     *
     * @return void
     */
    public function tagsAction()
    {
        $this->lockMethod('get');
        $this->checkState('tags');

        $this->widget('Widget_Metas_Tag_Cloud')->to($tags);

        if ($tags->have()) {
            while ($tags->next()) {
                $this->throwData($tags->stack);
            }
        }

        $this->throwError('no tag', 404);
    }

    /**
     * 获取文章、独立页面详情的接口
     *
     * @return void
     */
    public function postAction()
    {
        $this->lockMethod('get');
        $this->checkState('post');

        $slug = $this->getParams('slug', '');
        $cid = $this->getParams('cid', '');

        $select = $this->db
            ->select('cid', 'created', 'type', 'slug', 'commentsNum', 'text', 'agree')
            ->from('table.contents')
            ->where('password IS NULL');

        if (is_numeric($cid)) {
            $select->where('cid = ?', $cid);
        } else {
            $select->where('slug = ?', $slug);
        }

        $result = $this->db->fetchRow($select);
        if (count($result) != 0) {
            $result = $this->filter($result);
            $result['csrfToken'] = $this->generateCsrfToken($result['permalink']);
            $this->throwData($result);
        } else {
            $this->throwError('post not exists', 404);
        }
    }

    /**
     * 获取最新（最近）评论的接口
     *
     * @return void
     */
    public function recentCommentsAction()
    {
        $this->lockMethod('get');
        $this->checkState('recentComments');

        $size = $this->getParams('size', 9);
        $query = $this->db
            ->select('coid', 'cid', 'author', 'text')
            ->from('table.comments')
            ->where('type = ? AND status = ?', 'comment', 'approved')
            ->order('created', Typecho_Db::SORT_DESC)
            ->limit($size);
        $result = $this->db->fetchAll($query);

        $this->throwData(
            array(
                'count' => count($result),
                'dataSet' => $result
            )
        );
    }

    /**
     * 获取文章、独立页面评论列表的接口
     *
     * @return void
     */
    public function commentsAction()
    {
        $this->lockMethod('get');
        $this->checkState('comments');

        $pageSize = $this->getParams('pageSize', 5);
        $page = $this->getParams('page', 1);
        $page = is_numeric($page) ? $page : 1;
        $offset = $pageSize * ($page - 1);
        $slug = $this->getParams('slug', '');
        $cid = $this->getParams('cid', '');
        $order = strtolower($this->getParams('order', ''));

        // 为带 cookie 请求的用户显示正在等待审核的评论
        $author = Typecho_Cookie::get('__typecho_remember_author');
        $mail = Typecho_Cookie::get('__typecho_remember_mail');

        if (empty($cid) && empty($slug)) {
            $this->throwError('No specified posts.', 404);
        }

        $select = $this->db
            ->select('table.comments.coid', 'table.comments.parent', 'table.comments.cid', 'table.comments.created', 'table.comments.author', 'table.comments.mail', 'table.comments.url', 'table.comments.text', 'table.comments.status')
            ->from('table.comments')
            ->join('table.contents', 'table.comments.cid = table.contents.cid', Typecho_Db::LEFT_JOIN)
            ->where('table.comments.type = ?', 'comment')
            ->group('table.comments.coid')
            ->order('table.comments.created', $order === 'asc' ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC);

        if (empty($author)) {
            $select->where('table.comments.status = ?', 'approved');
        } else {
            $select
                ->where('table.comments.status = ? OR (table.comments.author = ? AND table.comments.mail = ?)', 'approved', $author, $mail);
        }

        if (is_numeric($cid)) {
            $select->where('table.comments.cid = ?', $cid);
        } else {
            $select->where('table.contents.slug = ?', $slug);
        }

        $result = $this->db->fetchAll($select);

        if (count($result) <= 0) {
            $count = 0;
            $finalResult = array();
        } else {
            $newResult = $this->buildNodes($result);
            $count = count($newResult);

            $finalResult = array_slice($newResult, $offset, $pageSize);
        }

        $this->throwData(
            array(
                'page' => (int) $page,
                'pageSize' => (int) $pageSize,
                'pages' => ceil($count / $pageSize),
                'count' => $count,
                'dataSet' => $finalResult,
            )
        );
    }

    /**
     * 发表评论的接口
     *
     * @return void
     */
    public function commentAction()
    {
        $this->lockMethod('post');
        $this->checkState('comment');

        $slug = $this->getParams('slug', '');
        $cid = $this->getParams('cid', '');
        $token = $this->getParams('token', '');

        // administrator
        $uid = $this->getParams('uid', null);
        $authCode = $this->getParams('authCode', null);
        $cookie = Typecho_Cookie::get('__typecho_uid');
        if (!empty($cookie)) {
            $uid = $cookie;
            $authCode = Typecho_Cookie::get('__typecho_authCode');
        }

        $select = $this->db->select('cid', 'created', 'type', 'slug', 'commentsNum', 'text')
            ->from('table.contents')
            ->where('password IS NULL');

        if (is_numeric($cid)) {
            $select->where('cid = ?', $cid);
        } else {
            $select->where('slug = ?', $slug);
        }

        $result = $this->db->fetchRow($select);
        if (count($result) != 0) {
            $result = $this->filter($result);
        } else {
            $this->throwError('post not exists', 404);
        }

        if (!$this->checkCsrfToken($result['permalink'], $token)) {
            $this->throwError('token invalid');
        }

        $commentUrl = Typecho_Router::url(
            'feedback',
            array('type' => 'comment', 'permalink' => $result['pathinfo']),
            $this->options->index
        );
        if (defined('IN_PHPUNIT_SERVER')) {
            $commentUrl = str_replace(':' . WEB_SERVER_PORT, ':' . FORKED_WEB_SERVER_PORT, $commentUrl);
        }

        $postData = empty($authCode) ? array(
            'text' => $this->getParams('text', ''),
            'author' => $this->getParams('author', ''),
            'mail' => $this->getParams('mail', ''),
            'url' => $this->getParams('url', ''),
        ) : array(
            'text' => $this->getParams('text'),
        );

        // Typecho 0.9- has no anti-spam security
        if (file_exists(__TYPECHO_ROOT_DIR__ . '/var/Widget/Security.php')) {
            $postData['_'] = $this->widget('Widget_Security')->getToken($result['permalink']);
        }

        $parent = $this->getParams('parent', '');
        if (is_numeric($parent)) {
            $postData['parent'] = $parent;
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $commentUrl);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'X-TYPECHO-RESTFUL-IP: ' . $this->request->getIp(),
            )
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->request->getAgent());
        curl_setopt($ch, CURLOPT_REFERER, $result['permalink']);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // no verify ssl

        if (!empty($authCode)) {
            $cookiePrefix = Typecho_Cookie::getPrefix();
            $cookieText = $cookiePrefix . '__typecho_uid=' . $uid . '; ' . $cookiePrefix . '__typecho_authCode=' . $authCode . ';';
            curl_setopt($ch, CURLOPT_COOKIE, $cookieText);
        }

        $data = curl_exec($ch);

        if (curl_error($ch)) {
            $this->throwError('comment failed');
        }

        curl_close($ch);

        preg_match('!(<title[^>]*>)(.*)(</title>)!i', $data, $matches);
        if (isset($matches[2]) && $matches[2] == 'Error') {
            preg_match('/<div class=\"container\">(.*?)<\/div>/s', $data, $matches);
            if (isset($matches[1])) {
                $this->throwError(trim($matches[1]));
            }
        }

        $query = $this->db->select('coid', 'status')
            ->from('table.comments')
            ->where('text = ?', $text)
            ->order('created', Typecho_Db::SORT_DESC);
        $res = $this->db->fetchRow($query);

        $this->throwData($res);
    }

    /**
     * 获取设置项的接口
     *
     * @return void
     */
    public function settingsAction()
    {
        $this->lockMethod('get');
        $this->checkState('settings');

        $key = trim($this->getParams('key', ''));
        $allowed = array_merge(
            explode(',', $this->config->allowedOptions),
            array(
                'title',
                'description',
                'keywords',
                'timezone',
            )
        );

        if (!empty($key)) {
            if (in_array($key, $allowed)) {
                $query = $this->db->select('*')
                    ->from('table.options')
                    ->where('name = ?', $key);
                $this->throwData($this->db->fetchAll($query));
            } else {
                $this->throwError('The options key you requested is therefore not allowed.', 403);
            }
        }

        $this->throwData(
            array(
                'title' => $this->options->title,
                'description' => $this->options->description,
                'keywords' => $this->options->keywords,
                'timezone' => $this->options->timezone,
            )
        );
    }

    /**
     * 获取作者信息和作者文章的接口
     *
     * @return void
     */
    public function usersAction()
    {
        $this->lockMethod('get');
        $this->checkState('users');

        $uid = $this->getParams('uid', '');
        $name = $this->getParams('name', '');

        $select = $this->db->select('uid', 'mail', 'url', 'screenName')
            ->from('table.users');
        if (!empty($uid)) {
            $select->where('uid = ?', $uid);
        } elseif (!empty($name)) {
            $select->where('name = ? OR screenName = ?', $name, $name);
        }

        $result = $this->db->fetchAll($select);
        $users = array();
        foreach ($result as $key => $value) {
            $postSelector = $this->db->select('cid', 'title', 'slug', 'created', 'modified', 'type')
                ->from('table.contents')
                ->where('status = ?', 'publish')
                ->where('password IS NULL')
                ->where('type = ?', 'post')
                ->where('authorId = ?', $value['uid']);
            $posts = $this->db->fetchAll($postSelector);
            foreach ($posts as $postNumber => $post) {
                $posts[$postNumber] = $this->filter($post);
            }

            array_push(
                $users,
                array(
                    "uid" => $value['uid'],
                    "name" => $value['screenName'],
                    "mailHash" => md5($value['mail']),
                    "url" => $value['url'],
                    "count" => count($posts),
                    "posts" => $posts,
                )
            );
        }

        $this->throwData(
            array(
                "count" => count($users),
                "dataSet" => $users,
            )
        );
    }

    /**
     * 归档页面接口
     *
     * @return void
     */
    public function archivesAction()
    {
        $this->lockMethod('get');
        $this->checkState('archives');
        $showContent = trim($this->getParams('showContent', '')) === 'true';
        $order = strtolower($this->getParams('order', 'desc'));

        $select = $this->db->select('cid', 'title', 'slug', 'created', 'modified', 'type', 'text')
            ->from('table.contents')
            ->where('status = ?', 'publish')
            ->where('password IS NULL')
            ->where('type = ?', 'post')
            ->order('created', $order === 'asc' ? Typecho_Db::SORT_ASC : Typecho_Db::SORT_DESC);
        $posts = $this->db->fetchAll($select);

        $archives = array();
        $created = array();
        foreach ($posts as $key => $post) {
            $post = $this->filter($post);
            if (!$showContent) {
                unset($post['text']);
            }

            $date = $post['created'];
            $year = date('Y', $date);
            $month = date('m', $date);
            $archives[$year] = isset($archives[$year]) ? $archives[$year] : array();
            $archives[$year][$month] = isset($archives[$year][$month])
                ? $archives[$year][$month]
                : array();
            array_push($archives[$year][$month], $post);
        }

        // sort by date descend / ascend
        if ($order !== 'asc') {
            krsort($archives, SORT_NUMERIC);
            foreach ($archives as $archive) {
                krsort($archive, SORT_NUMERIC);
            }
        } else {
            ksort($archives, SORT_NUMERIC);
            foreach ($archives as $archive) {
                ksort($archive, SORT_NUMERIC);
            }
        }

        $this->throwData(
            array(
                "count" => count($posts),
                "dataSet" => $archives,
            )
        );
    }

    /**
     * 主题配置项
     * 
     * @return void
     */
    public function themeOptionAction()
    {
        $this->lockMethod('get');
        $this->checkState('themeOption');

        $query = $this->db->select()->from('table.options')->where(' name = ?', 'theme:icefox');

        $result = $this->db->fetchAll($query);

        $this->throwData($result);
    }

    /**
     * 点赞
     */
    public function praiseAction()
    {
        $this->lockMethod('post');
        $this->checkState('praise');

        $cid = $this->getParams('cid', '');
        $isPraise = $this->getParams('isPraise');

        if (!empty($cid)) {
            $db = $this->db;
            $prefix = $db->getPrefix();

            if (!array_key_exists('agree', $db->fetchRow($db->select()->from('table.contents')))) {
                $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `agree` INT(30) DEFAULT 0;');
            }

            //先获取当前赞
            $row = $db->fetchRow($db->select('agree')->from('table.contents')->where('cid = ?', $cid));

            if ($isPraise == true)
                $updateRows = $db->query($db->update('table.contents')->rows(array('agree' => (int) $row['agree'] + 1))->where('cid = ?', $cid));
            else
                $updateRows = $db->query($db->update('table.contents')->rows(array('agree' => (int) $row['agree'] - 1))->where('cid = ?', $cid)->where('agree > 0'));

            if ($updateRows) {
                $state =  "success";
            } else {
                $state =  "error";
            }
        } else {
            $state = 'Illegal request';
        }

        $this->throwData($state);
    }

    /**
     * 插件更新接口
     *
     * @return void
     */
    public function upgradeAction()
    {
        $this->lockMethod('get');

        $isAdmin = call_user_func(function () {
            $hasLogin = $this->widget('Widget_User')->hasLogin();
            $isAdmin = false;
            if (!$hasLogin) {
                return false;
            }
            $isAdmin = $this->widget('Widget_User')->pass('administrator', true);
            return $isAdmin;
        }, $this);

        if (!$isAdmin) {
            $this->throwError('must be admin');
        }

        $localPluginPath = __DIR__ . '/Plugin.php';
        $localActionPath = __DIR__ . '/Action.php';
        $localPluginContent = file_get_contents($localPluginPath);
        $localActionContent = file_get_contents($localActionPath);

        $remotePluginContent = file_get_contents('https://raw.githubusercontent.com/moefront/typecho-plugin-Restful/master/Plugin.php');
        $remoteActionContent = file_get_contents('https://raw.githubusercontent.com/moefront/typecho-plugin-Restful/master/Action.php');

        if (!$remotePluginContent || !$remoteActionContent) {
            $this->throwError('unable to connect to GitHub');
        }

        if (
            md5($localPluginContent) != md5($remotePluginContent)
            || md5($localActionContent) != md5($remoteActionContent)
        ) {
            if (
                file_put_contents($localPluginPath, $remotePluginContent)
                && file_put_contents($localActionPath, $remoteActionContent)
            ) {
                $this->throwData(null);
            } else {
                $this->throwError('upgrade failed');
            }
        }
    }

    /**
     * 构造文章评论关系树
     *
     * @param array $raw      评论的集合
     * @return array          返回构造后的评论关系数组
     */
    private function buildNodes($comments)
    {
        $childMap = array();
        $parentMap = array();
        $tree = array();

        foreach ($comments as $index => $comment) {
            $comments[$index]['mailHash'] = md5($comment['mail']);
            unset($comments[$index]['mail']); // avoid exposing users' email to public

            $parent = (int) $comment['parent'];
            if ($parent !== 0) {
                if (!isset($childMap[$parent])) {
                    $childMap[$parent] = array();
                }
                array_push($childMap[$parent], $index);
            } else {
                array_push($parentMap, $index);
            }
        }

        $tree = $this->recursion($comments, $parentMap, $childMap);
        return $tree;
    }

    /**
     * 通过递归构建评论父子关系
     *
     * @param array $comments 评论集合
     * @param array $parents  父评论的 key 集合
     * @param array $map      子评论与父评论的映射关系
     * @return array          返回处理后的结果集合
     */
    private function recursion($comments, $parents, $map)
    {
        $result = array();

        foreach ($parents as $parent) {
            $item = &$comments[$parent];
            $coid = (int) $item['coid'];
            if (isset($map[$coid])) {
                $item['children'] = $this->recursion($comments, $map[$coid], $map);
            } else {
                $item['children'] = array();
            }
            array_push($result, $item);
        }

        return $result;
    }

    /**
     * 过滤和补全文章数组
     *
     * @param array $value 文章详细信息数组
     * @return array
     */
    private function filter($value)
    {
        $contentWidget = $this->widget('Widget_Abstract_Contents');
        $value['text'] = isset($value['text']) ? $value['text'] : null;

        if (method_exists($contentWidget, 'markdown')) {
            $value = $contentWidget->filter($value);
            $value['text'] = $contentWidget->markdown($value['text']);
        } else {
            // Typecho 0.9 compatibility
            $value['type'] = isset($value['type']) ? $value['type'] : null;
            $value = $contentWidget->filter($value);
            $value['text'] = MarkdownExtraExtended::defaultTransform($value['text']);
            if ($value['type'] === null) {
                unset($value['type']);
            }
            if (empty(trim($value['text']))) {
                unset($value['text']);
            }
        }
        // Custom fields
        $value['fields'] = $this->getCustomFields($value['cid']);

        return $value;
    }

    /**
     * 生成 CSRF Token
     *
     * @param mixed $key
     * @return string
     */
    private function generateCsrfToken($key)
    {
        return base64_encode(
            hash_hmac(
                'sha256',
                hash_hmac(
                    'sha256',
                    date('Ymd') . $this->request->getServer('REMOTE_ADDR') . $this->request->getServer('HTTP_USER_AGENT'),
                    hash('sha256', $key, true),
                    true
                ),
                $this->config->csrfSalt,
                true
            )
        );
    }

    /**
     * 检查 CSRF Token 是否匹配
     *
     * @param mixed $key
     * @param mixed $token
     * @return boolean
     */
    private function checkCsrfToken($key, $token)
    {
        return hash_equals($token, $this->generateCsrfToken($key));
    }
}
