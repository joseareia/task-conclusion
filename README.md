## Task Conclusion

PHP application to notify via e-mail if a certain task is complete.

### Dependencies

**Note**: Please make sure that you have `npm` and `composer` properly installed in your machine.

All the project dependencies are in the files `package.json` and `composer.json`.

### Usage

After cloning this project, copy file `.env.example` to a file with the name `.env` and fill all the environment variables with the correct data.

Then proceed to create a virtual-host or a server-block (NGINX denomination of virtual-host) for the application. Below there's a quick example of a server-block that you can use.

```shell
server {
    listen 80;
    listen [::]:80;

    root /srv/www/task-conclusion/dist;
    server_name task-conclusion.localhost;
    index index.html index.htm index.php;

    location / {
        try_files $uri $uri/ =404;
    }

    location ~ \.php$ {
    	fastcgi_pass unix:/var/run/php/php7.4-fpm.sock;
	    fastcgi_index index.php;
	    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
	    include fastcgi_params;
    }

    location ~ /\.ht {
	    deny all;
    }
}
```

### TODO

- Error handling in the login system
- Apply regex verifications on the text inputs
- Overall appearance of the application
- Appearance of the e-mail template

### License

This project is under the [GPL-3.0 license](https://www.gnu.org/licenses/gpl-3.0.en.html).
