<?php
    // src\DataFixtures\AppFixtures.php
 
namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\Rapport;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $userPasswordHasher;
    
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // Création d'un user "normal"
        $user = new User();
        $user->setFirstname("Amadou");
        $user->setLastname("Diarra");
        $user->setEmail("user@afribonemali.net");
        $user->setRoles(["ROLE_USER"]);
        $user->setPassword($this->userPasswordHasher->hashPassword($user, "password"));
        $manager->persist($user);
        
        // Création d'un user admin
        $userAdmin = new User();
        $userAdmin->setFirstname("Badra Aliou");
        $userAdmin->setLastname("Coumaré");
        $userAdmin->setEmail("admin@afribonemali.net");
        $userAdmin->setRoles(["ROLE_ADMIN"]);
        $userAdmin->setPassword($this->userPasswordHasher->hashPassword($userAdmin, "password"));
        $manager->persist($userAdmin);


        // Création d'une trentaine de rapport 
        for ($i = 0; $i < 30; $i++) {
            $rapport = new Rapport;
            $rapport->setInstallation(random_int(1, 10));
            $rapport->setInterqualite(random_int(0, 5));
            $rapport->setInterdepannage(random_int(1, 7));
            $rapport->setVisite(random_int(0, 4));
            $rapport->setRecuperation(random_int(0, 6));
            $rapport->setAutre('Autre information du rapport ' . $i);
            $manager->persist($rapport);
        }

        // Création des auteurs.
        // $listAuthor = [];
        // for ($i = 0; $i < 10; $i++) {
        //     // Création de l'auteur lui-même.
        //     $author = new Author();
        //     $author->setFirstName("Prénom " . $i);
        //     $author->setLastName("Nom " . $i);
        //     $manager->persist($author);

        //     // On sauvegarde l'auteur créé dans un tableau.
        //     $listAuthor[] = $author;
        // }

        // for ($i = 0; $i < 20; $i++) {
        //     $book = new Book();
        //     $book->setTitle("Titre " . $i);
        //     $book->setCoverText("Quatrième de couverture numéro : " . $i);
        //     $book->setAuthor($listAuthor[array_rand($listAuthor)]);
        //     $manager->persist($book);
        // }

        $manager->flush();
   }
}