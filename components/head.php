<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><?php $this->archiveTitle([
            'category' => _t('分类 %s 下的文章'),
            'search' => _t('包含关键字 %s 的文章'),
            'tag' => _t('标签 %s 下的文章'),
            'author' => _t('%s 发布的文章')
        ], '', ' - '); ?><?php $this->options->title(); ?></title>

    <!-- 使用url函数转换相关路径 -->
    <link rel="stylesheet" href="<?php $this->options->themeUrl('dist/style.css'); ?>">
    <script src="<?php $this->options->themeUrl('dist/icefox.iife.js') ?>"></script>
    <!--方便开发添加tailwindcss外链CDN-->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- 通过自有函数输出HTML头部信息 -->
    <script>
        // 方便开发添加的配置。正式发布后需要删除
        tailwind.config = {
            darkMode: 'class',
            content: ['**/*.php'],
            theme: {
                extend: {},
                container: {
                    center: true,
                },
                screens: {
                    'sm': '640px',
                    'md': '640px',
                    'lg': '640px',
                    'xl': '640px',
                    '2xl': '640px'
                }
            }
        }
    </script>
<!--    --><?php //$this->header(); ?>
</head>