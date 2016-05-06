# Phoenix Back-End

[![Join the chat at https://gitter.im/lijy91/phoenix-backend](https://badges.gitter.im/lijy91/phoenix-backend.svg)](https://gitter.im/lijy91/phoenix-backend?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)
[![Build Status](https://api.travis-ci.org/lijy91/phoenix-backend.svg?branch=master)](https://travis-ci.org/lijy91/phoenix-backend)

## 依赖
- [PHP >= 5.5.9](http://php.net/)
- [MySQL >= 5.6](https://www.mysql.com/)
- [Laravel >= 5.2](http://laravel.com/)

## 快速开始

### 克隆项目源码到本地
```
$ cd ~/Documents/Projects
$ git clone git@github.com:lijy91/phoenix-backend.git
$ cd phoenix-backend
```

### 使用 [Composer](https://getcomposer.org/) 安装依赖库
```
$ composer install
```

### 创建 `.env` 文件
```
$ cp .env.example .env
$ php artisan key:generate
```

### 修改根目录 `.env` 配置
```
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=phoenix_db
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

### 生成测试数据（***仅供开发测试时使用***）
```
$ php artisan db:seed --class=MockdataSeeder
```

### 运行
```
$ php artisan serve
$ open http://localhost:8000
```
或
```
$ npm start
```

### 创建一个业务开发分支（GitFlow）
```
$ git checkout develop
$ git pull
$ git flow feature start <NAME>
```

## 如何部署
TODO

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
