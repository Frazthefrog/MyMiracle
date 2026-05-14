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
For the authentication type, leave it on SSH public key and save this key in a safe disk space. If you lose this key, you will not be able to gain access to the server.
Type a name for your key if it is not already filled in.
Next, select these three ports: HTTP, HTTPS, and SSH.
Click next.
Choose one of the disk size options or leave as default.
For the disk type, choose a standard SSD type.
Now click Next: Networking.
Here, choose a Virtual network and a subnet if not already set by default.
Leave everything else as default and move to review and create.
If you run into any error, retrace your steps.
