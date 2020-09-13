# Nginx - Unable to start nginx - failed to read pid from file /run/nginx.pid

## That warning with the nginx.pid file is a know bug (at least for Ubutnu if not for other distros as well). More details here: https://bugs.launchpad.net/ubuntu/+source/nginx/+bug/1581864

```
// Workaround (on a ssh console, as root, use the commands bellow):
mkdir /etc/systemd/system/nginx.service.d
printf "[Service]\nExecStartPost=/bin/sleep 0.1\n" > /etc/systemd/system/nginx.service.d/override.conf
systemctl daemon-reload
systemctl restart nginx
```

# Can't access nginx server from outside

```
Add the rule to the permanent set and reload FirewallD:

sudo firewall-cmd --zone=public --add-service=http --permanent
sudo firewall-cmd --reload
```

# Can't use nginx as reverse proxy to direct traffic outside to containers

Fuck you --> SELinux --> Security Enhanced Linux

```
setsebool -P httpd_can_network_connect 1
```