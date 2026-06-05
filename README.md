## Student Details
**Student Name:** `Fraz Umar`
**Student ID:** `35962555`
**Video Explainer:** `link`
## Server Access Details
|Property|Value|
|---|---|
| IP Address | `104.214.189.100` |
|DNS|`pineraven.com`|

## Table of Content
1. [Creating a virtual Machine](#creating-a-virtual-machine)
2. [SSH into the server](#ssh-into-the-server)
3. [installing Nginx](#installing-nginx)
4. [Installing PHP](#installing-php-for-your-php-files)
5. [Configuring nginx to process PHP](#configure-nginx-to-process-php)
6. [Deploying Website Files](#deploying-website-files)
7. [User Authentication system](#user-authentication-system)
8. [Admin Panel](#admin-panel-configuration)
9. [Live Chat System](#live-chat-system)
10. [DNS Configuration](#dns-configuration)
11. [SSL/TLS Configuration](#ssltls-configuration)
12. [FTP Configuration(not required)](#configuring-ftp)
13. [Script](#script)
14. [References](#References)
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

## SSH into the server
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

## installing nginx
type the following commands
```bash
sudo apt update
sudo apt install nginx -y
```
enable nginx by typing
```bash
sudo systemctl start nginx
sudo systemctl enable nginx
```
---

## installing PHP for your php files
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
sudo chmod 777 /var/lib/php/sessions
```

---

## configure Nginx to process PHP
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
also 
Find the `index` line near the top of the server block and add `index.php` to it:

```nginx
index index.php index.html index.htm;
```
reload Nginx:
```bash
sudo nginx -t
sudo systemctl reload nginx
```

---

## Deploying Website Files
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

## User Authentication System

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

Users can now register and login at the webpage and will be redirected to their dashboard after signing in.

---
## Admin Panel configuration

nano into the admin file and use `Ctrl+w` and search for admin_pass
Find and update these two lines:
```javascript
var ADMIN_USER = 'admin';
var ADMIN_PASS = 'cybershield2026';
```
These will be the login details for the admins logging into the admin panel from https://pineraven.com/admin.php

---

## Live Chat System
The live chat allows clients to open a new live chat to get real-time support. The chat is saved for the admins to view and further contact the client from their email.
for the live chat,
Ensure the `chat_data` directory has correct permissions:

```bash
sudo mkdir -p /var/www/html/chat_data
sudo chown -R www-data:www-data /var/www/html/chat_data
sudo chmod -R 755 /var/www/html/chat_data
```

To verify the chat backend is working:

```bash
curl http://localhost/chat_backend.php?action=sessions
```

This should return `{"ok":true,"sessions":[]}`.

---


## DNS configuration
Log in to your Cloudflare account and purchase a domain based on your needs. In the home section click on Domains, then click Overview, click your domain name, then click DNS and then Records.
keep type A and for name keep it at @ for root name and add your ip in the address section you can get the ip from your virtual machine on Azure vm 
keep proxied status to on
Now add another record
put the type as CNAME and in the name type www and in target put your domain name
this will make an alias for your webserver so people can access www.yourdomain aswell
it should look like this:
| Type | Name | Value | Proxy |
|---|---|---|---|
| A | `@` | `your-ip-address` | Proxied (On) |
| CNAME | `www` | `yourdomain.com` | Proxied (On) |

dns propogation may take upto 24 hours
verify status using nslookup:
```bash
nslookup pineraven.com
```

---

## SSL/TLS configuration
You can turn on SSL directly from cloudflare but here I will show how to configure SSL via ssh in your webserver. In the terminal type
```bash
sudo apt install certbot python3-certbot-nginx -y
```
obtain and install the certificate:
```bash
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com
```
follow instructions while installing.
test automatic renewal as certificate expires after some time:
```bash
sudo certbot renew --dry-run
```

---

## Configuring FTP.
WARNING: FTP is not secure and you should not deploy it to your server, I just use it for testing, and downloading my server files quickly.
FTP can be configured to view and access your files directly from ftp protocol through applications such as Winscp.
Here,
Install vsftpd
use the following command:
```bash
sudo apt install vsftpd -y
```
Now configure it by going in 
```bash
sudo nano /etc/vsftpd.conf
```
and adding or changing these lines specifically:
```
anonymous_enable=NO
local_enable=YES
write_enable=YES
local_umask=022
chroot_local_user=YES
allow_writeable_chroot=YES
pasv_enable=YES
pasv_min_port=40000
pasv_max_port=50000
```
Now restart vsftpd:
```bash
sudo systemctl restart vsftpd
sudo systemctl enable vsftpd
```
After you are done configuring, go to Azure vm and click on networking then settings and click on create new port rule:
set protocol as TCP, Name as FTP and set service as FTP

Now click add and create another port rule
in second port rule select service as custom, set port range from 40000 to 50000, set protocol to TCP and put name as FTP-passive.

**login into your vm through ftp**
download winscp from https://winscp.net/download/WinSCP-6.5.6-Setup.exe/download
-Launch it and put ur ip address and username in details
-Leave password blank 
-Keep file protocol as SFTP
-Go in advanced and under SSH click Authentication  browse to  your_key.pem file
-Click login
you should be able to access the files from your vm.

---

## Script

The following Bash script checks whether Nginx is running and automatically restarts it if it has stopped. It also logs each check and any restart events to a log file, which provides an audit trail of server uptime.

```bash
#!/bin/bash
# check_nginx.sh
# Monitors Nginx and restarts it automatically if it stops.
# Logs all events to /var/log/nginx_monitor.log

SERVICE="nginx"
LOGFILE="/var/log/nginx_monitor.log"
TIMESTAMP=$(date "+%Y-%m-%d %H:%M:%S")

if systemctl is-active --quiet $SERVICE; then
    echo "$TIMESTAMP - $SERVICE is running." >> $LOGFILE
else
    echo "$TIMESTAMP - $SERVICE was not running. Attempting restart..." >> $LOGFILE
    sudo systemctl restart $SERVICE
    if systemctl is-active --quiet $SERVICE; then
        echo "$TIMESTAMP - $SERVICE restarted successfully." >> $LOGFILE
    else
        echo "$TIMESTAMP - $SERVICE failed to restart." >> $LOGFILE
    fi
fi
```

### How to Deploy the Script

Save the script to the server:

```bash
sudo nano /usr/local/bin/check_nginx.sh
```

Make it executable:

```bash
sudo chmod +x /usr/local/bin/check_nginx.sh
```
Create the log file with correct permissions:

```bash
sudo touch /var/log/nginx_monitor.log
sudo chmod 666 /var/log/nginx_monitor.log
```

Schedule it to run every 5 minutes using cron:

```bash
crontab -e
```

Add the following line:

```
*/5 * * * * /usr/local/bin/check_nginx.sh
```

### Verifying the Script Works

Stop Nginx manually and run the script to confirm it restarts Nginx:

```bash
sudo systemctl stop nginx
sudo /usr/local/bin/check_nginx.sh
sudo systemctl status nginx
```

Nginx should be active again. View the log file to confirm the restart was recorded:

```bash
cat /var/log/nginx_monitor.log
```
The live log output can be verified at: https://pineraven.com/nginx_log.php
---

## References

- Microsoft Azure Virtual Machine Documentation: https://learn.microsoft.com/en-us/azure/virtual-machines/
- Nginx: https://nginx.org/en/docs/
- Certbot (Let's Encrypt) for Nginx on Ubuntu: https://certbot.eff.org/
- PHP-FPM with Nginx: https://www.php.net/manual/en/install.fpm.php
- vsftpd: https://security.appspot.com/vsftpd.html
- WinSCP: https://winscp.net/eng/docs/start
- Cloudflare DNS: https://developers.cloudflare.com/dns/
- Generative AI used to assist with code styling.

