# Solution 1:
firewall-cmd --zone=public --add-masquerade --permanent
firewall-cmd --reload
-->test if works, return

# Solution 2:
firewall-cmd --permanent --zone=trusted --change-interface=docker0
firewall-cmd --permanent --zone=trusted --add-port=4243/tcp
firewall-cmd --reload
-->test again