# language: fr
Fonctionnalité: Reserver un rendez-vous
  Afin d'obtenir de pouvoir reserver une prestation
  En tant que client
  Je dois être capable d'acceder à la page déservation

  Scénario: Recherche un rendez-vous pour une coupe/shampooing/Brushing à 16h Mercredi 6 janvier autour de chez lui
    Etant donné ma géolocalisation
    Quand je recherche dans un rayon de 5km
       Et je recherche l’ensemble des des prestations correspondant coupe/shampooing/Brushing
       Et je recherche autour de 16h
    Alors je suis sur la page de résultat
       Et je dispose de la liste des salons par pertinence avec le créneau horaire et de distance

  Scénario: Visualisation des disponibilité d'une coupe/shampooing/Brushing à 16h Mercredi 6 janvier chez béa coiffure
    Etant donné que je suis sur la page des disponibilités
       Et une liste de prestataire met proposé suite à une recherche
    Quand quand je clique sur un prestataire "Béa coiffure"
    Alors j’accède à la page du professionnel
       Et je devrais voir les informations sur le salon
       Et je devrais voir ma demande de disponibilité surlignée sur un calendrier

  Scénario: Réservation d'une coupe/shampooing/Brushing à 16h Mercredi 6 janvier chez béa coiffure
    Etant donné que je suis sur la page du salon
       Et que le calendrier des disponibilité me propose un rendez-vous le Mercredi 6 janvier à 16:15
    Quand je clique sur 16:15 dans le calendrier
       Et que je clique sur le bouton réserver
    Alors je vois l’ensemble des données récapitulative apparaît à l’écran (Nom salon,, adresse, soin, date, horaire et employé) avec un bouton validé.
       Et je suis redirigée vers la page d’inscription (pour un non inscrit) ou je rentre directement sur ma page de profil particulier avec le rendez-vous inscrit sur celle-ci