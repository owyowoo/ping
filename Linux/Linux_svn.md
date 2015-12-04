安装svn
sudo apt-get install subversion
sudo apt-get install libapache2-svn

添加组
sudo groupadd subversion

添加用户
sudo adduser Medusa
sudo passwd Medusa Stone

将用户添加到组中
sudo usermod -G subversion -a Medusa

sudo mkdir /home/svn
cd /home/svn
sudo mkdir project
sudo chown -R Medusa:subversion project
sudo svnadmin create /home/svn/project
sudo chmod -R g+rws project
ls -l /home/svn/project/db/txn-current-lock


passwd
Test=123456

authz
[groups]
[/]
Test=rw
anon-access = read
auth-access = write
password-db = passwd
authz-db = authz

ps -aux|grep svnserve
kill -9 ID号
svnserve -d -r /home/svn

