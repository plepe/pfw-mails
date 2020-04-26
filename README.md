Sending Mails for Platz für Wien

# INSTALL
```sh
git clone https://github.com/plepe/pfw-mails
cd pfw-mails
composer install
cp conf.php-dist conf.php
edit conf.php
```

# RUN
Create resp. update files `template.txt` and `data.csv`

```sh
php sendmails.php
```
