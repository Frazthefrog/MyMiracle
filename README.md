## Server Access Details
| IP Address | '104.214.189.100' |
|DNS|'pineraven.com'|

# MyMiracle
# Creating a Virtual Machine
Web server hosting is offered by multiple sources like Azure, Amazon AWS or Google Cloud etc. In this project, I will be using Microsoft Azure. To create a virtual machine to host your web server, go to https://portal.azure.com/
After creating your account, go to the home page.
Click the Virtual Machine button under Azure services.
In the Virtual Machine section, click the Create button, and a drop-down box will appear. Click the virtual machine button.
Now you have to choose specific options bassed on your web server needs, For my simple web server the instructions are as follows:
Choose the subscription as Virtual Computing Lab.
Under the Resource Group bar, click Create New. Type a name for your new Resource Group
Scroll down and type a name for your virtual machine.
Now choose a region for your server. I chose the East Asia region.
Scroll down and choose a zone as per your need, or leave it as default.
After that, in the image drop-down bar, click the Ubuntu Server 24.04 x64 Gen2.
The next step is to choose an appropriate VM size based on your server's needs. The Standard_B2ats_v2 works well for a small web server.
For the authentication type, leave it on SSH public key and save this key in a safe disk space. You should be able to download this key in the last step when you create the Virtual Machine. If you lose this key, you will not be able to gain access to the server.
Type a name for your key if it is not already filled in.
Next, select these three ports: HTTP, HTTPS, and SSH.
Click next.
Choose one of the disk size options or leave as default.
For the disk type, choose a standard SSD type.
Now click Next: Networking.
Here, choose a Virtual network and a subnet if not already set by default.
Leave everything else as default and move to review and create.
If you run into any error, retrace your steps.
After creating your Virtual machine, get the IP address.
Next step is to SSH into your server and gain access.
# SSH into the server
go into the terminal from location where you private key is located. To do this right click on the empty space in the location and click open in terminal
in your windows terminal type:
icacls "Booking_key.pem" /inheritance:r /grant:r "YourWindowsUsername:R"
or for linux users type:
chmod 400 your_key.pem
then
ssh -i your_key.pem username@your-ip
you should have access to the server now
# installing nginx
type the following commands
sudo apt update
sudo apt update -y
sudo apt install nginx -y
enable nginx by typing
sudo systemctl start nginx
sudo systemctl enable nginx
# html code
nano into your html file and paste your html code in there by typing
nano /var/www/html/index.html
# installign PHP for your php files
type 
sudo apt install php-fpm php-cli -y
check version number:
php -v
# configure Nginx to process php
sudo nano /etc/nginx/sites-available/default
find the location - \.php code and replace it with 
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
}
reload Nginx:
sudo nginx -t
sudo systemctl reload nginx
# Deploying web files
create files for different sections of your webserver and paste the code
1. sudo nano /var/www/html/admin.php
2. sudo nano /var/www/html/chat.php
3. sudo nano /var/www/html/chat_backend.php #to make sure live chat works.

# Ensure nginx can read your files 
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
# DNS configuration
Login to your cloudflare account and buy a domain bassed on your needs
In home section click on domains and click overview
Click your domain name
now click dns and click records
Click on add records
keep type A and for name keep it at @ for root name and add your ip in the address section you can get the ip from your virtual Comachine on Azure vm 
keep proxied status to on
Now add another record
put the type as CNAME and in the name type www and in target put your domain name
this will make an alias for your webserver so people can access www.yourdomain aswell
# SSL/TLS configuration
you can turn on ssl directly from cloudflare but here i will show how to configure ssl via ssh in your webserver
in the terminal type
sudo apt install certbot python3-certbot-nginx -y
obtain and install the certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
follow instructions while installing.
test automatic renewal as certificate expires after some time:
sudo certbot renew --dry-run
# Configuring FTP.
Install vsftpd
use the following command:
sudo apt update
sudo apt install vsftpd -y
Now configure it by going in 
sudo nano /etc/vsftpd.conf
and adding or changing these lines specifically:
anonymous_enable=NO
local_enable=YES
write_enable=YES
local_umask=022
chroot_local_user=YES
allow_writeable_chroot=YES
pasv_enable=YES
pasv_min_port=40000
pasv_max_port=50000
Now restart vsftpd:
sudo systemctl restart vsftpd
sudo systemctl enable vsftpd
After you are done configuring, go to Azure vm and click on networking then settings and click on create new port rule:
set protocol as TCP, Name as FTP and set service as FTP
now click add and create another port rule
in second port rule select service as custom, set port range from 40000 to 50000, set protocol to TCP and put name as FTP-passive.
**login into your vm through ftp**
download winscp from https://winscp.net/download/WinSCP-6.5.6-Setup.exe/download
launch it and put ur ip address username in details, leave password blank and keep file protocol as SFTP go in advanced and under SSH click Authentication  browse to  your_key.pem file and click login
you should be able to access the files from your vm.

