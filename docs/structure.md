# Icefox 主题文件结构

## 📁 根目录结构

```
icefox/
├── 📁 assets/                 # 静态资源文件
│   ├── 📁 css/                # CSS 样式文件
│   ├── 📁 js/                 # JavaScript 文件
│   ├── 📁 fonts/              # 字体文件
│   ├── 📁 svgs/               # SVG 图标文件
│   └── 📁 images/             # 图片文件
├── 📁 components/             # 页面组件
│   ├── 📁 post-items/         # 文章子组件
│   ├── header.php             # 页面头部
│   ├── footer.php             # 页面底部
│   ├── option-header.php      # 选项头部
│   ├── modal.php              # 模态框
│   ├── post-item.php          # 文章项目组件
│   ├── post-list.php          # 文章列表组件
│   ├── post-item-comment.php  # 评论组件
│   └── single-*.php           # 单页组件
├── 📁 core/                   # 核心功能
│   ├── api.php                # API 接口
│   ├── article.php            # 文章相关方法
│   ├── comment.php            # 评论相关方法
│   └── core.php               # 核心工具函数
├── 📁 main/                   # 主要源文件
├── 📁 api/                    # API 目录
├── 📄 index.php               # 主页
├── 📄 post.php                # 文章页
├── 📄 page.php                # 页面
├── 📄 archive.php             # 归档页
├── 📄 functions.php           # 主题函数
├── 📄 404.php                 # 404 页面
├── 📄 package.json            # Node.js 依赖
├── 📄 vite.config.ts          # Vite 配置
├── 📄 uno.config.ts           # UnoCSS 配置
└── 📄 uno.css                 # UnoCSS 生成的样式
```

## 🏗️ 组件架构

### 页面组件 (components/)
- **header.php** - 页面头部，包含样式和脚本引用
- **footer.php** - 页面底部，包含版权信息和隐藏数据容器
- **option-header.php** - 选项头部，包含背景图和用户信息
- **modal.php** - 模态框，包含友链和音乐播放器
- **post-list.php** - 文章列表，处理置顶和普通文章
- **post-item.php** - 文章项目，单个文章的完整展示

### 文章子组件 (components/post-items/)
- **post-item-music.php** - 音乐卡片
- **post-item-video.php** - 视频播放器
- **post-item-images.php** - 图片展示
- **post-item-position.php** - 定位信息
- **post-item-line-time.php** - 时间线
- **post-item-comment.php** - 评论列表

### 核心功能 (core/)
- **api.php** - RESTful API 接口
- **article.php** - 文章相关工具函数
- **comment.php** - 评论相关工具函数
- **core.php** - 通用工具函数

## 📋 文件说明

### 主要页面文件
- **index.php** - 主页，仿微信朋友圈样式
- **post.php** - 文章详情页
- **page.php** - 独立页面
- **archive.php** - 文章归档页
- **404.php** - 404 错误页面

### 配置文件
- **functions.php** - 主题初始化和配置
- **package.json** - Node.js 依赖和构建脚本
- **vite.config.ts** - Vite 构建配置
- **uno.config.ts** - UnoCSS 配置

## 🔄 优化后的改进

### 1. 代码组织优化
- 按功能模块化组织代码
- 统一的命名规范
- 清晰的文件层级结构

### 2. 性能优化
- 优化了 JavaScript 和 CSS 的加载顺序
- 改进了资源引用方式
- 增加了错误处理机制

### 3. 安全性增强
- 增加了输入验证和过滤
- 改进了 XSS 防护
- 使用 htmlspecialchars() 处理输出

### 4. 可维护性提升
- 添加了详细的注释
- 统一的代码风格
- 更好的错误处理

### 5. 结构优化
- 分离了文章子组件
- 改进了配置管理
- 优化了模板继承结构

## 📝 开发建议

1. **新增功能**：在相应的模块目录下创建文件
2. **修改样式**：编辑 assets/css/ 目录下的文件
3. **添加脚本**：在 assets/js/ 目录下创建新文件
4. **修改配置**：编辑 functions.php 或 core/ 目录下的文件
5. **组件开发**：在 components/ 目录下创建新组件