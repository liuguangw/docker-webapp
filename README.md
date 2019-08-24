# 流光的docker环境
这是一个使用[docker](https://www.docker.com/)、[docker-compose](https://github.com/docker/compose)工具构建的lnmp环境：nginx+php+mysql+redis

### docker环境安装

如果已经安装了装[docker](https://www.docker.com/)、[docker-compose](https://github.com/docker/compose)工具，可以忽略docker环境安装步骤。

#### 安装docker

```bash
wget -qO- https://get.docker.com/ | sh
```

#### 安装docker-compose

```bash
curl -L https://github.com/docker/compose/releases/download/1.24.1/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose
```

### 项目环境安装方法

```bash
#克隆项目到本地
git clone https://github.com/liuguangw/docker-webapp.git
cd docker-webapp
#给脚本添加执行权限
chmod +x *.sh
#复制 .env.dist 到 .env (复制后注意:参考.env文件内的资料,修改初始密码等信息!!!!)
copy .env.dist .env
#启动
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
logs - 日志
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

> 可以看到，只有nginx的443、80端口，被映射到了宿主机的端口，其它端口只有在容器内部才可以互相访问。
>
> 所以如果php脚本需要访问MySQL服务，只需要连接db_server:3306即可,Redis的则为redis_server:6379。
>
> 建议通过环境变量获取对应服务的host，具体可见[index.php](app/sites/localhost/public/index.php)中的示例。



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

#### 管理数据库、Redis脚本

```bash
#管理数据库
./admin_db.sh
#管理Redis
./admin_redis.sh
#进入php容器
./admin_php.sh
```

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

