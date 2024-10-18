# Opper - Api test technique

## Démarrage du projet

```bash
# Cloner le projet
git clone https://github.com/HamidiMehdi/opper-api.git

# Se rendre dans le dossier du projet
cd opper-api

# Build l'image perso de php apache
docker-compose build

# Lancer les conteneurs docker
docker-compose up -d

# Télécharger les lib
composer install

# Supprimer la bdd si elle existe
docker-compose exec web php bin/console doctrine:database:drop --if-exists --force

# Creer la bdd
docker-compose exec web php bin/console doctrine:database:create

# Lancer les migrations
docker-compose exec web php bin/console doctrine:migration:migrate

# Lancer les fixtures
docker-compose exec web php bin/console doctrine:fixtures:load -n
```

## Accès aux applications
```bash
# L'application est accessible via cette url
127.0.0.1:8000

# Accès au phpadmin
127.0.0.1:8899
```

## Accès aux enpoints de l'api
```bash
# Liste des subscriptions
127.0.0.1:8000/subscription/{id}
Methode : GET
Code HTTP : 200

# Créer une subscription
127.0.0.1:8000/subscription
Methode : POST
Code HTTP : 201
Exemple de données 
{
    "contact": {"id": 23},
    "product": {"id": 12},
    "beginDate": "2024-10-17",
    "endDate": "2024-10-18"
}

# Modifier une subscription
127.0.0.1:8000/subscription/{id}
Methode : PUT
Code HTTP : 200
Exemple de données 
{
    "contact": {"id": 23},
    "product": {"id": 12},
    "beginDate": "2024-10-17",
    "endDate": "2024-10-18"
}

# Supprimer une subscription
127.0.0.1:8000/subscription/{id}
Methode : DELETE
Code HTTP : 204
```
