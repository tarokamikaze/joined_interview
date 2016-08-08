<?php
namespace AppBundle\Model;

use Symfony\Component\DependencyInjection\ContainerInterface;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * ブログ記事に関わるビジネスロジッククラス。
 * フレームワークの機能で、プロセスごとにシングルトンになる。
 *
 * @package AppBundle\Model
 * @Service("article_model")
 */
class ArticleModel
{
    /**
     * DIコンテナ.
     *
     * @var ContainerInterface
     */
    public $container;

    /**
     * @var bool
     */
    public $counterIsIncremented = false;

    /**
     * @param $id
     * @return array
     */
    public function find($id)
    {
        $article = $this->getDb()->fetchAll(<<<SQL
SELECT * FROM article WHERE id = $id;
SQL
        );
        // fetchAll は1行でも配列で返してくるので注意
        $article = reset($article);

        $this->incrementCounter($article);

        return $article;
    }

    /**
     * @param array $article
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function incrementCounter(array $article)
    {
        if (!$this->counterIsIncremented) {
            $currentCounter = $article['counter'];
            $id = $article['id'];
            $currentCounter++;
            $this->getDb()->executeQuery(<<<SQL
UPDATE article SET counter = $currentCounter WHERE id = $id;
SQL
            );

            $this->counterIsIncremented = true;

            return true;
        }

        return false;
    }

    /**
     * @param $name
     * @param $description
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function register($name, $description)
    {
        $this->getDb()->executeQuery(<<<SQL
INSERT INTO article (name, description, counter) VALUES ($name, $description, 0);
SQL
        );

        return true;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getDb()
    {
        // フレームワーク（DIコンテナ）の機能で、PDOを返す。
        return $this->container->get('doctrine.dbal.connection');
    }
}