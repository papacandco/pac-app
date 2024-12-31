!#/usr/bin/env bash

# Reset previous config
ufw reset

# Show current status
ufw status

# Enable firewall
ufw enable

# Set the basic rule
ufw allow http
ufw allow https
ufw allow ssh
ufw allow 25
ufw allow 7890

# List of apps
ufw app list
ufw enable
