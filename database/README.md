# 数据库导入说明

`order.sql` 来自原项目上级目录中的 SQL 导出，包含 10 张表。保留字段、存储引擎、主键及非账号参考数据；原 `up`、`player`、`customer`、`seller` 数据行已去除，原始文件保持不变。

| 表 | 原项目用途 |
| --- | --- |
| up | 网站登录账号 |
| player | 玩家账号 |
| character_name | 角色名称和季票 |
| chara_update | 更新角色列表 |
| chara_delay | 延迟更新角色列表 |
| address | 旧系统地区数据 |
| customer | 玩家资料（沿用旧表名） |
| seller | 旧系统商家数据 |
| goods | 旧系统商品数据 |
| test | 原测试数据 |

## 导入到独立空库

此 SQL 不包含 `CREATE DATABASE` 或 `USE`。先创建并选择空库，不要直接导入已有业务库。

在 MySQL 客户端中执行以下语句，最后一行路径替换为克隆后的实际绝对路径（Windows 可使用正斜杠）：

```sql
CREATE DATABASE `order` CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `order`;
SOURCE C:/path/to/repository/database/order.sql;
```

也可以在 phpMyAdmin 中创建空库，选中该库后导入 `order.sql`。如果 `order` 已存在，请使用其他新库名，同时修改根目录 `.env` 的 `database` 配置。

导入后可执行 `SHOW TABLES;` 核对 10 张表。`up` 和 `player` 初始为空。现有网页注册写入的是 `up` 表，不是 `player` 表。

角色和玩家资料的增删改查依赖 `character_name.name` 与 `customer.cno` 主键。仓库中的 `order.sql` 已包含这些修正；如果数据库是由旧版 SQL 创建的，请先备份，再执行 `migrations/001_fix_crud_schema.sql` 一次。该迁移不适合重复执行。

数据库仍混用 MyISAM 与 InnoDB，且没有定义外键。这些结构问题不影响本次增删改查修复，后续可以通过单独迁移继续整理。
