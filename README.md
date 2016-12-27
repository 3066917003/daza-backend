# Daza.io Back-End

[「daza.io」](https://daza.io)是一款基于技能树的技术内容聚合应用，根据你的技能对内容进行筛选，让你在这个信息过载的时代里更高效地获取你所需的内容。

[![Build Status](https://api.travis-ci.org/lijy91/daza-backend.svg?branch=master)](https://travis-ci.org/lijy91/daza-backend)

## 截图
![](https://oeolgl6y5.qnssl.com/topic/ByRafuLR/r1Cg7u8A.png?imageView2/2/w/1280/h/1280)

## 线上地址
- 主页：[https://daza.io](https://daza.io)
- 接口：[https://api.daza.io](https://api.daza.io)

## 项目说明
> 本项目使用 PHP + MySQL 进行开发，基于 Laravel 框架的 API Only 项目。

### 项目依赖
- [PHP >= 5.5.9](http://php.net/)
- [MySQL >= 5.6](https://www.mysql.com/)
- [Laravel >= 5.3](http://laravel.com/)

## 入门指南

### 克隆项目源码到本地
```
$ cd ~/Documents/Projects
$ git clone git@github.com:lijy91/daza-backend.git
$ cd daza-backend
```

### 使用 [Composer](https://getcomposer.org/) 安装项目依赖
```
$ composer install
```

### 配置环境变量
#### 创建 `.env` 配置文件
```
$ cp .env.example .env
$ php artisan key:generate
```

#### 修改相关配置
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=daza_db
DB_USERNAME=root
DB_PASSWORD=
```

### 执行数据库迁移
```
$ php artisan migrate
```

### 生成基础数据
```
$ php artisan db:seed
```

### 生成测试数据（***从现有主题爬取文章***）
```
$ php artisan ag:rss
```

### 运行
```
$ php artisan serve
$ open http://localhost:8000
```

## 相关项目
- [daza-backend](https://github.com/lijy91/daza-backend)
- [daza-frontend](https://github.com/lijy91/daza-frontend)
- [daza-ios](https://github.com/lijy91/daza-ios)
- [daza-android](https://github.com/lijy91/daza-android)

## 关于作者

![](https://oeolgl6y5.qnssl.com/topic/ByRafuLR/r1no_q9R.jpg?imageView2/2/w/200)

> 如果你有什么好想法想告诉我，或者想加入讨论组（注明加入讨论组），请加我微信。

## 捐赠

![](http://obryq3mj0.bkt.clouddn.com/topic/ByRafuLR/r1WH8F90.jpg?imageView2/2/w/200)

> 如果你觉得我的工作对你有帮助，那你可以为项目捐赠运营费用。

## License

    Copyright (C) 2015 JianyingLi <lijy91@foxmail.com>

    Licensed under the Apache License, Version 2.0 (the "License");
    you may not use this file except in compliance with the License.
    You may obtain a copy of the License at

        http://www.apache.org/licenses/LICENSE-2.0

    Unless required by applicable law or agreed to in writing, software
    distributed under the License is distributed on an "AS IS" BASIS,
    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
    See the License for the specific language governing permissions and
    limitations under the License.
