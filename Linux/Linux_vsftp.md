vsftp安装
$ sudo apt-get install vsftpd
$ sudo netstat -npltu | grep 21
ftp localhost

1.standalone
    $ sudo service vsftpd start
2.super daemon
    listen=NO
    $ sudo apt-get install xinetd
    $ sudo vi /etc/xinetd.conf
    service ftp
    {
        socket_type             = stream
        wait                    = no
        user                    = root
        server                  = /usr/sbin/vsftpd
        log_on_success          += DURATION USERID
        log_on_failure          += USERID
        nice                    = 10
        disable                 = no
    }
    $ sudo service vsftpd stop
    $ sudo service xinetd restart
    $ sudo netstat -npltu | grep 21

1.配置参数说明：

listen=YES  设置为YES时vsftpd以独立运行方式启动，设置为NO时以xinetd方式启动（xinetd是管理守护进程的，将服务集中管理，可以减少大量服务的资源消耗）
listen_port=21     设置控制连接的监听端口号，默认为21
listen_ipv6=YES     将在绑定到指定IP地址运行，适合多网卡

connect_from_port_20=YES    若为YES，则强迫FTP－DATA的数据传送使用port 20，默认YES

pasv_enable=YES  是否使用被动模式的数据连接，如果客户机在防火墙后，请开启为YES
pasv_min_port=<n>
pasv_max_port=<m>  设置被动模式后的数据连接端口范围在n和m之间,建议为50000－60000端口

anonymous_enable=NO 设置是否支持匿名用户访问
local_enable=YES  设置是否支持本地用户帐号访问
guest_enable=<YES/NO> :设置是否支持虚拟用户帐号访问
write_enable=YES 是否开放本地用户的写权限
local_umask=022 设置本地用户上传的文件的生成掩码，默认为077
local_max_rate<n> :设置本地用户最大的传输速率，单位为bytes/sec，值为0表示不限制
local_root=<file> :设置本地用户登陆后的目录，默认为本地用户的主目录

anon_upload_enable=YES  设置是否允许匿名用户上传
anon_max_rate=<n> :设置匿名用户的最大传输速率，单位为B/s，值为0表示不限
anon_mkdir_write_enable=YES :设置是否允许匿名用户创建目录
anon_other_write_enable=<YES/NO> :设置是否允许匿名用户其他的写权限（注意，这个在安全上比较重要，一般不建议开，不过关闭会不支持续传）
anon_umask=<nnn> :设置匿名用户上传的文件的生成掩码，默认为077

message_file=<filename> :设置使用者进入某个目录时显示的文件内容，默认为 .message
dirmessage_enable=YES :设置使用者进入某个目录时是否显示由message_file指定的文件内容
ftpd_banner=<message> :设置用户连接服务器后的显示信息，就是欢迎信息
banner_file=<filename> :设置用户连接服务器后的显示信息存放在指定的filename文件中
use_localtime=YES
xferlog_enable=YES
connect_from_port_20=YES

chown_uploads=YES  
chown_username=whoever

xferlog_file=/var/log/vsftpd.log
xferlog_std_format=YES
idle_session_timeout=600

connect_timeout=<n> :如果客户机连接服务器超过N秒，则强制断线，默认60
accept_timeout=<n> :当使用者以被动模式进行数据传输时，服务器发出passive port指令等待客户机超过N秒，则强制断线，默认
accept_connection_timeout=<n> :设置空闲的数据连接在N秒后中断，默认120
data_connection_timeout=120 设置空闲的用户会话在N秒后中断，默认300

max_clients=<n> : 在独立启动时限制服务器的连接数，0表示无限制
max_per_ip=<n> :在独立启动时限制客户机每IP的连接数，0表示无限制

nopriv_user=ftpsecure
async_abor_enable=YES
ascii_upload_enable=YES
ascii_download_enable=YES
ftpd_banner=Welcome to blah FTP service.
deny_email_enable=YES
banned_email_file=/etc/vsftpd.banned_emails

chroot_local_user=YES  当为YES时，所有本地用户可以执行chroot
chroot_list_enable=YES
chroot_list_file=/etc/vsftpd.chroot_list  当chroot_local_user=NO 且 chroot_list_enable=YES时，只有filename文件指定的用户可以执行chroot

ls_recurse_enable=YES
secure_chroot_dir=/var/run/vsftpd/empty
pam_service_name=vsftpd
rsa_cert_file=/etc/ssl/certs/ssl-cert-snakeoil.pem
rsa_private_key_file=/etc/ssl/private/ssl-cert-snakeoil.ke


2.示例1：只允许登录用户在家目录内上传下载
    1.创建用户
    useradd NovaRoma//新增用户
    passwd NovaRoma//设置密码:Constantinople

    gpasswd -a NovaRoma ftp//用户添加到管理组

    mkdir /home/NovaRoma//创建家目录
    chown NovaRoma /home/NovaRoma

    2.配置vsftp
    listen=NO//xinetd方式运行下
    anonymous_enable=NO
    local_enable=YES
    write_enable=YES
   
    3.错误与解决
    530 login incorrect
    pam_service_name=ftp

    500 OOPS: vsftpd: refusing to run with writable root inside chroot ()
    chmod a-w /home/user
    allow_writeable_chroot=YES

    4.修改用户家目录
    id NovaRoma
    usermod -d /var/www -u 1000 NovaRoma 

3.相关链接
http://vsftpd.beasts.org/vsftpd_conf.html
http://wiki.ubuntu.org.cn/Vsftpd
http://linux.die.net/man/5/vsftpd.conf