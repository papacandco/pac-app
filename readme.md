# Papac & Co

Improve your programming skills, and your understanding of computer systems with international standards and learn new techniques thanks to rich and varied free tutorials.

[https://papac.dev](https://papac.dev "Papac & Co")

[![papac-and-co](https://github.com/papacandcoapp/papac-and-co/actions/workflows/01_tests.yml/badge.svg)](https://github.com/papacandcoapp/papac-and-co/actions/workflows/01_tests.yml)

## Install

Clone the repository and install all dependencies.

The requirements:

- Composer for installing the PHP dependencies
- Npm for compiling the assets
- Install the AWS CLI and make the configuration (contact [@papac](mailto:dakiafranck@gmail.com) for the credentials). The setting should be made on the VPS/EC2 server Create a virtual host for dev environment:

```dns
127.0.0.1 codelearningclub.test
```

> In `/etc/hosts` for Linux system or `C:/Windows/system32/drivers/etc/hosts` for windows.

### Install dependencies

Installation of project php dependencies like this.

```bash
composer update
```

Installation frontend dep

```bash
npm install
```

### Migration

After, making the migration

```bash
php bow migrate --seed
php bow seed:all
```

### Docker Service

If you want to make a development configuration you can run the docker service.
Copy the .env.docker to .env and run the following command

```bash
docker compose up -d
```
