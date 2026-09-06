# 已知问题

以下来自源码和 `database/order.sql` 的静态核对，未进行网站启动、SQL 导入或业务验收。

1. `application/index/view/common/header.html` 中的 `update_player`、`del_player`、`del_chara` 链接在 `Admin` 控制器中没有对应操作。
2. `Admin` 中的卖家增删改逻辑引用 `Seller` 模型，但项目未包含该模型文件。
3. `add_customer_check`、`update_customer_check` 对 `player` 模型使用 `cno`、`name`、`address`、`gno` 等旧顾客字段，实际表只有 `username`、`password`。
4. `search_character_any` 查询 `character_name.business`，SQL 中没有该字段；其默认模板也不存在。
5. `search_character_delay` 没有导入 `app\index\model\Chara_delay`，且默认模板名与现有 `chara_delay.html` 不一致。
6. `Chara_update` 与 `character_name` 模型声明的字段与 SQL 不一致；`search_character_update.html` 使用不存在的 `character_id`。
7. `add_chara.html` 的提交地址 `admin/Admin/add_chara_check` 与现有模块和操作不对应；角色删除模板仍沿用顾客变量。
8. 修改密码模板使用 `session.Uname`，登录写入 `session.uname`；提交账号取自表单，需统一身份来源和校验。
9. 密码按原样保存、直接比较，数据库字段是整数；缺少完善的密码存储与角色权限设计。
10. `search_customer_1.html` 的角色卡片与数据写在页面中，仅在浏览器中搜索、筛选，未从数据库读取。
11. 部分图片使用包含 `public` 的相对路径，与 `public/` 作为 Web 根目录的部署方式可能不一致；部分样式、脚本依赖 CDN。
12. 数据字典规划的招式帧数、受击框、录像上传、胜负统计、管理权限和版本历史，尚未发现完整实现及对应数据表。

本次 Git 整理只调整配置读取与文件组织，以上问题保留为后续修复清单。
