OldPics
=======

Een Supersimpele inteface om foto's te delen. 

**EEN BEZOEKER**
* kan de homepage zien
* kan zich registreren


**SUPEROPA**
* kan alles wat een bezoeker kan
* kan inloggen
* kan alle mappen met foto's zien
* kan alle foto's in een map zien
* kan alle foto's apart zien


**ADMIN**
* kan alles wat een BEZOEKER en een SUPEROPA kunnen
* kan een map toevoegen
* kan foto's toevoegen
* Kan zijn eigen foto's en folders bewerken en verwijderen
* kan uitloggen


**SUPERADMIN**
* kan alles wat een BEZOEKER, SUPEROPA en een ADMIN kunnen
* Kan alle foto's en folders bewerken en verwijderen
* kan een gebruiker een rol toedienen

***____________________________________________________***


**(Eventueel) nog toe te voegen**
* IP-authentication voor SUPEROPA of op andere manier versimpelen?
* Structuur verbeteren/AdminBundles toevoegen
* Home Button SuperOpa
* Paginering aan zijkant ipv onderaan de foto


***____________________________________________________***

**Opzet**
* Run composer install
* Give right permissions to var 
* Run php bin/console doctrine:schema:create
* Run php bin/console doctrine:schema:update --force
* ....

***____________________________________________________***

**Gebruikt**
* Symfony 3.1
* PHP 5.6
* Alice/fixtures
* Knp Paginator
* Cloudinary
* Heroku 
* Postgres
