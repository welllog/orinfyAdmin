### 安装步骤

1. 下载或克隆项目，进入项目根目录执行``composer install``,等待框架安装
2. 将.env.example修改为.env,并进行相关配置,然后在项目根目录执行``php artisan key:generate``
3. 手动创建数据库,执行``php artisan migrate:refresh --seed``迁移数据库表结构和数据
4. 配置好环境即可运行

### 注意事项
* 需要环境为php>7。
* 默认配置使用了redis及phpredis扩展，可自行更改相应配置
* 目前仅实现了后台登录及权限功能
* 后台路由: domain/admin