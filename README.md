# 流光的docker环境
这是一个使用[docker](https://www.docker.com/)、[docker-compose](https://github.com/docker/compose)工具构建的lnmp环境：nginx+php+mysql+redis

### 安装方法

首先需要安装[docker](https://www.docker.com/)、[docker-compose](https://github.com/docker/compose)工具，然后复制[.env.dist](.env.dist)文件到`.env`,参考文件内的注释修改，最后执行`run.sh`脚本文件即可启动。

```bash
git clone https://github.com/liuguangw/docker-webapp.git
cd docker-webapp
chmod +x *.sh
./run.sh
```

### 文件目录说明

```
app - 项目文件夹
	db_data - 数据库文件存放目录
	redis_data - redis文件存放目录
	config - 配置目录
		nginx - nginx配置目录
			vhost - 虚拟主机配置
				localhost.conf - 默认网站配置文件
				sitea.conf - 网站a配置文件
				siteb.conf - 网站b配置文件
		php - php配置目录
			php.ini php配置文件
		redis.conf redis配置文件
		
	sites - 网站目录
		localhost - 默认网站
			public - 默认网站根目录
		sitea - 网站a
			public - 网站a根目录
		siteb - 网站b
			public - 网站b根目录
		...

			...
backup - 备份
	app20180428.tar.gz - 2018/4/28日备份
	app20180429.tar.gz - 2018/4/29日备份
	...
.env - docker-compose服务环境变量配置文件
docker-compose.yml docker-compose项目定义文件
run.sh - 服务启动脚本
stop.sh - 服务停止脚本
admin_db.sh - 数据库管理脚本
admin_redis.sh - redis管理脚本
service_save.sh - 备份服务脚本
service_rewind.sh - 从备份文件中恢复服务脚本
```

### 管理命令

查看服务进程

```bash
docker-compose ps
```

输出结果如下

```
    Name                  Command               State                    Ports
------------------------------------------------------------------------------------------------
db_server      docker-entrypoint.sh --def ...   Up      3306/tcp, 33060/tcp
nginx          nginx -g daemon off;             Up      0.0.0.0:443->443/tcp, 0.0.0.0:80->80/tcp
php_server     docker-php-entrypoint php-fpm    Up      9000/tcp
redis_server   docker-entrypoint.sh /etc/ ...   Up      6379/tcp
```

进入服务容器的命令行

```bash
docker-compose exec 服务名 bash
```

各服务名称

| 项目    | 服务名        |
| ------- | ------------- |
| php服务 | php_server    |
| web服务 | nginx         |
| redis   | redis_server  |
| 数据库  | db_server     |

### 备份与还原

备份直接运行service_save.sh即可

```bash
./service_save.sh
#备份文件在backup目录,格式为 app备份日期.tar.gz
#例如 backup/app20180428.tar.gz(2018/4/28日备份)
```

还原命令如下

```bash
./service_rewind.sh [日期]
#例如还原2018年4月8日的备份
./service_rewind.sh 20180408
#日期参数为可选参数,如果不指定日期,则会还原最后一次的备份
./service_rewind.sh
```

