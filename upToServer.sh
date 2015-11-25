#!/bin/sh
#默认ARCH=Release KEEP_INCLUDE_DIR="" [KeepDir]
CONFIG_FILE="$HOME/serverUp.conf"




if [[ -f $CONFIG_FILE ]]
then
	echo 'path file is OK'
	. $CONFIG_FILE
else
	echo 'server_path="$HOME/"' > $CONFIG_FILE
	echo '请修改~/:你的trunk工程对应的路径'
	sleep 2
	nano $CONFIG_FILE
	echo "请重新运行此脚本"
	exit 0
fi

PRODUCT="$server_path/ios"

rm -Rf "$PRODUCT"

mkdir -p "$PRODUCT"

cp -r controllers "$PRODUCT"
cp -r models "$PRODUCT"

#cp -r views "$PRODUCT"


#CP
uikit_path="$PRODUCT"

echo "拷贝上线文件到product文件中"

echo "$uikit_path"

scp -r "$uikit_path" root@182.92.114.79:/home/www/


