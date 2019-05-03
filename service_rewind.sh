#!/bin/sh
	
#获取需要还原的日期
mark_path=`pwd`/backup/.backup
save_date=""
if [ $# -ge 1 ]; then
	save_date=${1}
elif [ -f "${mark_path}" ];then
	save_date=`cat ${mark_path}`
else
	echo "no backup found";
	exit 1
fi

#操作确认
echo "prepare to rewind app from backup (${save_date})"
read -p "Do you want to continue? [Y/n]" ask_option
ask_option=$(echo $ask_option | tr '[A-Z]' '[a-z]')
if [ "$ask_option" != "y" ]; then
	echo "rewind action canceled"
	exit 0
fi

#判断备份是否存在
save_path=`pwd`/backup/app${save_date}.tar.gz
if [ ! -f "${save_path}" ];then
	echo "backup file ${save_path} not found"
else
	echo "starting rewind app from ${save_path}"
	./stop.sh
	rm -rf app
	rm -rf .env
	tar -zxvf ${save_path}
	./run.sh
fi
