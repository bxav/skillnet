# language: fr
Fonctionnalité: acceder à la page d'un salon
  Afin d'obtenir des info sur un salon
  En tant que client
  Je dois être capable d'acceder à la page

  Contexte:
    Etant donné there is 1 business like:
      | name |
      | Haircut Master |

  Scénario: Acceder à la page principal
    Etant donné je suis sur la page d'accueil
    Quand je suis "haircut-master"
    Alors je devrais voir "Toutes Belles"