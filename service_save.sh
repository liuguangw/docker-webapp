#!/bin/sh

save_date=`date +%Y%m%d`
save_path=`pwd`/backup/app${save_date}.tar.gz
mark_path=`pwd`/backup/.backup
./stop.sh
echo "starting save app to ${save_path}"
tar -zcvf ${save_path} app .env
echo "$save_date">"$mark_path"
./run.sh
