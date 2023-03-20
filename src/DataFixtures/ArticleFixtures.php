<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\Comment;
use \Faker\Factory;
class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {   $faker = \Faker\Factory::create('fr_FR');
        // Créer 3 catégories faker
        for($i = 1; $i <= 3; $i++){
            $category = new Category();
            $category->setTitle($faker->paragraph())
                     ->setDescription($faker->paragraph());
                    $manager->persist($category);
        //Créer entre 4 et 6 articles
        for($j = 1; $j <= mt_rand(4,6); $j++){
            $content = '<p>' . join($faker->paragraphs(5),'</p><p>').'</p>';
            $article = new Article();
            $article->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage("http://placehold.it/350x150")
                    ->setCreateAt(new \DateTimeImmutable())
                    ->setCategory($category);
            
              $manager->persist($article);
              // on donne  des commentaires à l'article
              for($k = 1; $k <= mt_rand(4,10); $k++){
                $comment = new Comment();
                $content = '<p>' . join($faker->paragraphs(5),'</p><p>').'</p>';
                $days = (new \DateTime())->diff($article->getCreateAt())->days;
                $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt(new \DateTimeImmutable())
                        ->setArticle($article); 
                        $manager->persist($comment);  

              }
        } 
    }
        
        $manager->flush();
    }
}
