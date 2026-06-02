## Server Access Details
|Property|Value|
|---|---|
| IP Address | '104.214.189.100' |
|DNS|'pineraven.com'|

## Table of Content
1. [Creating a virtual Machine](#creating-a-virutal-machine)
2. [SSH into the server](#ssh-into-the-server)
3. [installing Nginx](#installing-nginx)
4. [Deploying Website Files](#deploying-website-files)
5. [User Authentication system](#user-authentication-system)
# Creating a Virtual Machine
Web server hosting is offered by multiple sources like Azure, Amazon AWS, or Google Cloud. In this project, I will be using Microsoft Azure. To create a virtual machine to host your web server, go to [https://portal.azure.com/](https://portal.azure.com/)

After creating your account, go to the home page. Click the Virtual Machine button under Azure services. In the Virtual Machine section, click the Create button, and a drop-down box will appear. Click the virtual machine button.

Now you have to choose specific options based on your web server needs. For my simple web server, the instructions are as follows:
 -Choose the subscription as **Virtual Computing Lab**
- Under the Resource Group bar, click **Create New** and type a name for your new Resource Group
- Scroll down and type a name for your virtual machine
- Choose a region for your server. I chose the **East Asia** region
- Scroll down and choose a zone as per your need, or leave it as default
- In the image drop-down bar, select **Ubuntu Server 24.04 x64 Gen2**
- Choose an appropriate VM size based on your server needs. **Standard_B2ats_v2** works well for a small web server
- For the authentication type, leave it on **SSH public key** and save this key in a safe location. You should be able to download this key in the last step when you create the Virtual Machine. If you lose this key, you will not be able to gain access to the server
- Type a name for your key if it is not already filled in
- Select these three inbound ports: **HTTP**, **HTTPS**, and **SSH**
- Click Next, choose one of the disk size options or leave as default
- For the disk type, choose a **Standard SSD**
- Click **Next: Networking**, choose a Virtual network and a subnet if not already set by default
- Leave everything else as default and move to **Review and Create**
- If you run into any error, retrace your steps
- After creating your Virtual Machine, get the IP address from the VM overview page
- Next step is to SSH into your server and gain access

---

# SSH into the server
Open the terminal from the location where your private key is stored. On Windows, right-click on the empty space in the folder and click **Open in Terminal**.

On Windows, you must first fix the key file permissions using `icacls` instead of `chmod`:

```cmd
icacls "Booking_key.pem" /inheritance:r /grant:r "YourWindowsUsername:R"
```

To find your Windows username, run:

```cmd
whoami
```

Use only the part after the backslash. Then SSH in:

```cmd
ssh -i Booking_key.pem azureuser@your-ip
```

For Linux/Mac users:

```bash
chmod 400 your_key.pem
ssh -i your_key.pem azureuser@your-ip
```

You should now have shell access to the server.

---

# installing nginx
type the following commands
```bash
sudo apt update
sudo apt update -y
sudo apt install nginx -y
```
enable nginx by typing
```bash
sudo systemctl start nginx
sudo systemctl enable nginx
```
---

# installign PHP for your php files
You must install PHP processor:
Type:
```bash
sudo apt install php-fpm php-cli -y
```
check version number:
```bash
php -v
```
my server returned PHP 8.3.6
version 8.3 is needed and should be noted down

Now, fix PHP permissions so sessions work properly:
```bash
sudo chmod 777/var/lib/php/sessions
```

---

# configure Nginx to process PHP
Open default Nginx Configuration file:
```bash
sudo nano /etc/nginx/sites-available/default
```
find the location - \.php code and replace it with 
```nginx
location ~ \.php$ {
    include snippets/fastcgi-php.conf;
    fastcgi_pass unix:/run/php/php8.3-fpm.sock;
}
```
reload Nginx:
```nginx
sudo nginx -t
sudo systemctl reload nginx
```

---

# Deploying Website Files
All website files are placed in `/var/www/html`.
The following files are needed
index.html chat.php chat_backend.php admin.php user_login.php user_auth.php dashboard.php get_bookings.php

Create each file using nano:
```bash
sudo nano /var/www/html/index.html
sudo nano /var/www/html/chat.php
sudo nano /var/www/html/chat_backend.php
sudo nano /var/www/html/admin.php
sudo nano /var/www/html/user_login.php
sudo nano /var/www/html/user_auth.php
sudo nano /var/www/html/dashboard.php
sudo nano /var/www/html/get_bookings.php
```
Paste the relevant code into each file and save.

Create the required data directories:

```bash
sudo mkdir -p /var/www/html/chat_data
sudo mkdir -p /var/www/html/uploads
```

Ensure Nginx can read and write to all files:

```bash
sudo chown -R www-data:www-data /var/www/html
sudo chmod -R 755 /var/www/html
```

---

# User Authentication System

Users must create an account before they can book a consultation. Passwords are stored as bcrypt hashes and the system includes rate limiting and PHP session management.

Ensure session storage is writable:

```bash
sudo chmod 777 /var/lib/php/sessions
```

Ensure correct permissions on the data directory:

```bash
sudo chown -R www-data:www-data /var/www/html/chat_data
sudo chmod -R 755 /var/www/html/chat_data
```

Users can now register and login at `yourdomain.com/user_login.php` and will be redirected to their dashboard after signing in.

---

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

