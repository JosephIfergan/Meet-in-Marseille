# MeetInMarseille
Joseph OK !
MAX ok! Its ok!



revu le cours:

=> Chaque dev a un fichier controller pour ne pas se gener

- dans le terminal : 
```
php ../composer.phar require symfony/apache-pack (pour avoir le fichier htaccess dans le dossier public).
```
## CONTROLLER
- on créer nos fichiers controller pour chaque page dans le dossier controller: AccueilControler.php, InscriptionController.php ...

=> Avec le terminal ouvert dans le dossier bin/console (click droit sur console et open terminale):

```
php bin/console make:controller
```
    =>cela créer un fichier Exemplecontroller et un dossier Exemple avec un fichier index.html.twig dans templates.

- ensuite dans la fonction dans notre fichier controller on ajoute : 
```php
public function index(): Response
    {
        return $this->render('accueil/index.html.twig', [
            'controller_name' => 'AccueilController',
        ]);
    }
```

Controller à créer : 

- AccueilController OK
- InscriptionController OK 


- ConnexionController
- RejoindreMeetingController
- CreerMeetingController
- AdminController



















