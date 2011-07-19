<VirtualHost *:80>

    ServerName [[PROJECT_DOMAIN]]

    DocumentRoot [[PROJECT_ROOT]]/htdocs/project/web

    <Directory [[PROJECT_ROOT]]/htdocs/project/web>

        <FilesMatch "^\.gitignore">
        
            Order allow,deny
            Deny from all
            
        </FilesMatch>

        Options Indexes FollowSymLinks
        AllowOverride All
        Order allow,deny
        allow from all
        
        Options +FollowSymLinks +ExecCGI

        <IfModule mod_rewrite.c>
        
            RewriteEngine On

            # uncomment the following line, if you are having trouble
            # getting no_script_name to work
            #RewriteBase /

            # we skip all files with .something
            #RewriteCond %{REQUEST_URI} \..+$
            #RewriteCond %{REQUEST_URI} !\.html$
            #RewriteRule .* - [L]

            # we check if the .html version is here (caching)
            RewriteRule ^$ index.html [QSA]
            RewriteRule ^([^.]+)$ $1.html [QSA]
            RewriteCond %{REQUEST_FILENAME} !-f

            # no, so we redirect to our front web controller
            RewriteRule ^(.*)$ index.php [QSA,L]
            
        </IfModule>


    </Directory>

    ErrorLog [[PROJECT_ROOT]]/htdocs/logs/error.log
    CustomLog [[PROJECT_ROOT]]/htdocs/logs/access.log combined

</VirtualHost>