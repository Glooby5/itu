# itu

## config.local.neon sample
```
database:    
        dsn: 'mysql:host=127.0.0.1;dbname=test'
        user:
        password:
    
doctrine:
        user: homestead
        password: secret
        dbname: itu
        metadata:
                App: %appDir%/entities
```

- vytvoření databáze `php www/index.php orm:schema-tool:create`
- přidání uživatele `php app/bin/create-user.php kaderabek.jan@gmail.com Heslo123`
