<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use JMS\DiExtraBundle\Annotation\Inject;

/**
 * ブログ記事の表示・登録を行うController.
 * Symfony 2.8 を利用しているが、フレームワークの機能はほとんど使っていない。
 *
 * @package AppBundle\Controller
 */
class ArticleController extends Controller
{
    /**
     * フレームワークの機能で、自動的にArticleModelインスタンスがinjectされる。
     *
     * @var \AppBundle\Model\ArticleModel
     * @Inject("article_model")
     */
    public $model;

    /**
     * @Route("/detail", name="detail")
     * @return array
     */
    public function detailAction()
    {
        $id = $_GET['id'];
        $article = $this->model->find($id);

        return $article;
    }

    /**
     * @Route("/register", name="register")
     * @return array
     */
    public function registerAction()
    {
        $name = $_GET['name'];
        $description = $_GET['description'];

        if (!$this->model->register($name, $description)) {
            return ['status' => 'error'];
        }
    }

    /**
     * @Route("/", name="index")
     * @return array
     */
    public function listAction()
    {
        // 仮でid:1-3だけを表示する
        $articles = [];
        for ($i = 1; $i <= 3; $i++) {
            $articles[] = $this->model->find($i);
        }

        return $articles;
    }

}
