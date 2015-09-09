# language: fr
Fonctionnalité: Reserver un rendez-vous
  Afin d'obtenir de pouvoir reserver une prestation
  En tant que client
  Je dois être capable d'acceder à la page déservation

  Contexte:
    Etant donné there is 1 business like:
      | name |
      | Béa coiffure |
    Et the following employee:
      | username | plainPassword | roles | enabled | firstname | lastname | business |
      | user | user | ROLE_API | true | marie | dupond | Béa coiffure |
    Et the following services:
      | business | duration | type |
      | Béa coiffure | 30 | Coiffure |
      | Béa coiffure | 130 | Brushing |

  @ignore
  Scénario: Recherche un rendez-vous pour une coupe/shampooing/Brushing à 16h le 8 septembre autour de chez lui
    Etant donné ma géolocalisation
    Quand je recherche dans un rayon de 5km
       Et je recherche l’ensemble des des prestations correspondant coupe/shampooing/Brushing
       Et je recherche autour de 16h
    Alors je suis sur la page de résultat
       Et je dispose de la liste des salons par pertinence avec le créneau horaire et de distance

  Scénario: Visualisation des disponibilité d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffure
    Etant donné que je suis sur la page des disponibilités
       Et une liste de prestataires m'est proposé suite à une recherche
    Quand quand je clique sur un prestataire "Béa coiffure"
    Alors je devrais être sur la page du professionnel "Béa coiffure"
       Et je devrais voir les informations sur le salon
       Et je devrais voir ma demande de disponibilité surlignée sur un calendrier

  Scénario: Réservation d'une coupe/shampooing/Brushing à 16h le 8 septembre chez béa coiffure
    Etant donné je suis sur la page du professionnel "Béa coiffure" et que je recherche un rendez-vous pour une "Coiffure"
    Quand je clique sur "16:15" dans le calendrier
       Et que je clique sur le bouton réserver
    Alors je vois l’ensemble des données récapitulative apparaît à l’écran (Nom salon,, adresse, soin, date, horaire et employé) avec un bouton validé.
       Et je suis redirigée vers la page d’inscription (pour un non inscrit) ou je rentre directement sur ma page de profil particulier avec le rendez-vous inscrit sur celle-ci