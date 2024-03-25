<?php

if (!defined('__TYPECHO_ROOT_DIR__'))
    exit;

?>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $this->options->title ?>
    </title>
    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/style.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/viewer.min.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('uno.css'); ?>">
    <link rel="stylesheet" href="<?php $this->options->themeUrl('assets/fancybox.css'); ?>">
    <style>
        <?php echo $this->options->css; ?>
    </style>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/jquery.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/axios.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/viewer.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/scrollload.min.js'); ?>"></script>
    <script defer src="<?php $this->options->themeUrl('assets/alpine.3.13.3.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/fancybox.umd.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/lazyload.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php $this->options->themeUrl('assets/icefox.js'); ?>"></script>
    <script type="text/javascript">
        <?php echo $this->options->script; ?>
    </script>    <!-- 通过自有函数输出HTML头部信息 -->
    <?php $this->header(); ?>
</head>

<body :class="{'dark':darkMode}" x-data="{darkMode:false}">
    <div class="bg-[#f0f0f0] dark:bg-[#262626]">