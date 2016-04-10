# PlumeProject

Norme :
PHP doit être utilisé uniquement par le biais des objets
Pour cela, veillez à n'utiliser aucune fonction dans votre code

Architecture MVC

Pour les types, on peut (et il est recommandé pour les array et les string), les transformer en objet
- Str : remplace stting
- Collection : remplace array
- Number : remplace int, double...
- bool n'est pas transformé
- NULL n'est pas transformé