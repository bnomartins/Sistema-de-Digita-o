<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Custom\Convert;
use Application\Entity\Candidate\Candidate;
use Application\Entity\Candidate\Typing;
use DateTime;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\AST\Join;
use Doctrine\ORM\Query\Expr\Join as ExprJoin;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Laminas\Http\PhpEnvironment\Request;

use Application\Custom\Log;
use Application\Entity\Candidate\Phrase;

class PhraseController extends AbstractActionController
{
    protected $em;
    protected $request;

    public function __construct(EntityManager $_em)
    {
        $this->em = $_em;
        // $_SESSION["ssEntity"]["id"] = 5000;
    }

    public function indexAction()
    {
        $viewModel = new ViewModel();
        return $viewModel;
    }

    private function save()
    {
        try {


            $dados = $this->request->getPost();
            $phrase = new Phrase();
            // name social cpf nascimento telefone email
            $frase = "";
            if (mb_strpos($dados['frase'], '–') !== true) {
                $frase = str_replace('–', '-', $dados['frase']);
            } else {
                $frase = $dados['frase'];
            }

            $phrase->setPhrase($frase);

            $query = $this->em->createQuery('SELECT p FROM Application\Entity\Candidate\Phrase p WHERE p.phrase = :frase');

            $query->setParameter('frase', $frase);
            $phrases = $query->getResult();

            $msg = "";
            if (empty($phrases)) {
                $result = $this->em->persist($phrase);

                if (!$result) {
                    $msg = "Dados inseridos com sucesso";
                } else {
                    $msg = "Não foi possível realizar a inclusão";
                }
                $this->em->flush();
            } else {
                $msg = "Frase já estava cadastrada";
            }

            return $msg;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }
    }
    private function update($id)
    {
        try {
            $msg = '';
            $dados = $this->request->getPost();
            $phrase = $this->em->getRepository(Phrase::class)->findOneBy([
                "id" => $id
            ]);
            // name social cpf nascimento telefone email

            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado
            $phrase->setPhrase($dados['frase']);
            $this->em->persist($phrase);
            $this->em->flush();

            $msg = "Realizado atualização";

            return $msg;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }
    }


    public function saveOrUpdateAction()
    {
        try {
            $msg = '';
            if ($this->request->isPost()) {
                $dados = $this->request->getPost();
                if (!empty($dados['id'])) {
                    $msg = $this->update($dados['id']);
                } else {
                    $msg = $this->save();
                }
                // dd($data);
                // echo $data['cpf'];

                // * getQuery()
                // * getPost()
                // * getCookie()
                // * getServer()
                // * getEnv()

                /**
                 * Desabilitando o layout
                 */
                // $this->getHelper('layout')->disableLayout();
                // // $this->_helper->layout->disableLayout();

                // /**
                //  * Desabilita a renderização da view
                //  */
                // $this->getHelper('viewRenderer')->setNoRender();
                // // $this->_helper->viewRenderer->setNoRender();

                // /**
                //  * Renderiza uma determinada view
                //  */
                // resolução ajax
                // $this->render('my-view');
                // $view = new \Zend\View\Model\ViewModel();
                // $view->setTerminal(true);

                // return $view;
            }

            // $this->redirect()->toRoute('/');

            $viewModel = new ViewModel(['msg' => $msg]);
            $viewModel->setTerminal(true);
            return $viewModel;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }
    }

    public function removeAction()
    {
        
        try {
            $msg = '';
            $dados = $this->request->getPost();
            $phrase = $this->em->getRepository(Phrase::class)->findOneBy([
                "id" => $dados['id']
            ]);
            // name social cpf nascimento telefone email

            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado
            $this->em->remove($phrase);
            $this->em->flush();

            $msg = "Realizado remoção da frase";

            $viewModel = new ViewModel(['msg' => $msg]);
            $viewModel->setTerminal(true);
            return $viewModel;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }
        
    }
}