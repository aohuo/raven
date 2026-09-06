# GGST 格斗数据管理网站

基于 ThinkPHP 5.0.7 和 MySQL 的课程项目，包含账号登录、注册、后台管理页面与 GGST 角色图鉴。由已有管理系统改造而来，当前仍有订单管理残留，以及页面、控制器和数据库字段不一致的问题。

本仓库保存源码、去除原账号及联系信息的数据文件和运行说明，作为后续修复、学习和开发的基线。设计文档和个人资料不纳入仓库。仓库整理不代表全部业务功能已经可用；目前未完成 PHP / MySQL 环境下的运行验证。

## 技术与目录

- 后端：PHP、仓库内附带的 ThinkPHP 5.0.7。
- 数据库：MySQL；原始 SQL 导出头记录 MySQL 5.7.26、PHP 7.3.4，这只是历史环境信息。
- 页面：ThinkPHP 模板、Bootstrap 3、jQuery、原生 JavaScript。
- 部分页面依赖外部 CDN；角色图鉴目前使用写在 HTML 中的数据。

```text
application/          应用配置、控制器、模型和页面模板
public/               网站入口及静态资源（Web 根目录）
thinkphp/             随项目保存的框架源码
extend/               扩展目录
vendor/               Composer 依赖目录（生成内容不提交）
runtime/              运行时缓存、日志（生成内容不提交）
database/order.sql    全部 10 张表的结构及部分参考数据
docs/legacy/          原项目 README，保留来源信息
.env.example          本地配置示例
```

## 本地准备

1. 将仓库克隆到本地并进入仓库根目录：

   ```powershell
   git clone https://github.com/aohuo/raven.git
   cd raven
   ```

2. 准备 PHP、PDO MySQL 扩展和 MySQL。框架清单声明 PHP `>=5.4.0`，但这不保证兼容所有更高版本，尤其未验证 PHP 8。首次复现应在隔离的本地环境中进行。
3. 复制配置模板（Windows PowerShell）：

   ```powershell
   Copy-Item .env.example .env
   ```

   编辑 `.env`，填写自己的数据库地址、数据库名、用户名和密码。`.env` 被 Git 忽略。`APP_DEBUG` 用 `1` 或 `0`；没有本地配置时，应用默认关闭调试。

4. 创建空数据库并导入 `database/order.sql`，具体见 [数据库说明](database/README.md)。
5. 将 Web 根目录指向 `public/`，并允许 PHP 写入 `runtime/`。使用 Apache 时，仓库已有 `public/.htaccess`；其他 Web 服务器需配置相应重写规则。

也可以在仓库根目录尝试 PHP 内置开发服务器：

```powershell
php -S 127.0.0.1:8000 -t public public/router.php
```

然后访问 `http://127.0.0.1:8000/index.php`。该启动方式来自项目现有入口与路由脚本，尚未在本次整理中运行验证。图片路径、角色管理等已知问题见下方清单。

项目已经包含框架源码，首次复现无需先执行 `composer update`。现有 `composer.json` 保留原始 `^5.0` 约束且没有锁文件，更新依赖可能改变实际框架版本；后续依赖升级应单独进行和验证。

## 数据与账号

导入文件保留全部表结构，去除了原 `up`、`player`、`customer`、`seller` 表中的记录，不提供原始账号密码。连接数据库后，可通过现有注册页面创建本地测试账号。

当前账号密码字段仍是整数，现有注册代码也没有密码哈希。仅为复现旧代码时，测试密码需使用整数范围内的非零数字；不要使用自己的真实密码。账号设计修复前，不应将其作为可公开使用的登录系统。

## 项目现状与来源

- [已知问题](docs/KNOWN_ISSUES.md)：源码与 SQL 静态核对结果。
- [原始 README](docs/legacy/README.original.md)：原项目来源信息。

仓库保留现有 `LICENSE.txt`、框架许可证和源码中的版权说明。游戏素材的权利范围不因本次 Git 整理而改变。
