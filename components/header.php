<?php

if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

/**
 * 页面头部组件
 * 包含网站基础信息、CSS样式、JavaScript等资源
 */
?>
<!DOCTYPE HTML>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="<?php echo $this->options->description; ?>">
    <meta name="keywords" content="<?php echo $this->options->keywords; ?>">
    
    <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search'   => _t('包含关键字 %s 的文章'),
            'tag'      => _t('标签 %s 下的文章'),
            'author'   => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>
    
    <!-- 主题样式 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('uno.css'); ?>?v=<?php echo __THEME_VERSION__; ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/style.css'); ?>?v=<?php echo __THEME_VERSION__; ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/viewer.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/fancybox.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/css/plyr.css'); ?>">
    
    <!-- 自定义样式 -->
    <style><?php echo $this->options->css; ?></style>
    
    <!-- 基础 JavaScript 库 -->
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/axios.min.js'); ?>"></script>
    
    <!-- 功能性 JavaScript 库 -->
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jqueryui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/jquery.ui.touch.punch.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/lazyload.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/scrollload.min.js'); ?>"></script>
    
    <!-- 媒体相关 JavaScript 库 -->
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/viewer.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/fancybox.umd.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/plyr.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/hls.min.js'); ?>"></script>
    
    <!-- 动画和交互 -->
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/anime.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/intersection-observer.min.js'); ?>"></script>
    
    <!-- 主题核心脚本 -->
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/icefox.js'); ?>?v=<?php echo __THEME_VERSION__; ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/js/edit.js'); ?>?v=<?php echo __THEME_VERSION__; ?>"></script>
    
    <!-- 自定义脚本 -->
    <script type="text/javascript"><?php echo $this->options->script; ?></script>
    
    <!-- Typecho 头部输出 -->
    <?php $this->header(); ?>
</head>

<body>
    <div class="bg-[#f0f0f0] dark:bg-[#262626] min-h-screen">
        <div class="min-h-full">