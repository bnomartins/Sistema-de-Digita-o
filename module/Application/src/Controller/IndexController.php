<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Custom\Convert;
use Application\Custom\Cript;
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
use Application\Custom\VerifySession;
use Application\Entity\Candidate\Phrase;
use Application\Entity\Candidate\User;

class IndexController extends AbstractActionController
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
        return new ViewModel();
    }

    public function candidateAction()
    {
        return new ViewModel();
    }

    public function admAction()
    {
        return new ViewModel();
    }

    private function save()
    {
        try {
                //code...
            $dados = $this->request->getPost();
            $candidate = new Candidate();
            // name social cpf nascimento telefone email
            $candidate->setNome($dados['nome']);
            $candidate->setSocial($dados['social']);
            $candidate->setCpf($dados['cpf']); //uniq
            // $candidate->setNascimento($dados['nascimento']);
            $candidate->setTelefone($dados['telefone']);
            $candidate->setEmail($dados['email']); //uniq
            $candidate->setCep($dados['cep']);
            $candidate->setEndereco($dados['endereco']);
            $candidate->setBairro($dados['bairro']);
            $candidate->setCidade($dados['cidade']);
            $candidate->setEstado($dados['estado']);
            if(!empty($dados['nascimento'])){
                $candidate->setNascimento(DateTime::createFromFormat('Y-m-d', $dados['nascimento']));
            }

            $query = $this->em->createQuery('SELECT c FROM Application\Entity\Candidate\Candidate c WHERE c.cpf = :cpf or c.email = :email');
            
            $query->setParameter('cpf', $dados['cpf']);
            $query->setParameter('email', $dados['email']);
            $candidates = $query->getResult();

            $msg = "";
            if(empty($candidates)){
                $result = $this->em->persist($candidate);
        
                if (!$result) {
                    $msg = "Dados inseridos com sucesso";
                } else {
                    $msg = "Não foi possível realizar a inclusão";
                }
                $this->em->flush();
            } else {
                $msg = "Cpf e/ou email já estão cadastrados";
            }

            return $msg;

        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        
    }
    private function update($id){

        try{

            $msg = '';
            $dados = $this->request->getPost();
            $candidate = $this->em->getRepository(Candidate::class)->findOneBy([
                "id" => $id
            ]);
            // name social cpf nascimento telefone email

            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado
            $candidate->setNome($dados['nome']);
            $candidate->setSocial($dados['social']);
            $candidate->setCpf($dados['cpf']);
            $candidate->setNascimento($dados['nascimento']);
            $candidate->setTelefone($dados['telefone']);
            $candidate->setEmail($dados['email']);
            $candidate->setCep($dados['cep']);
            $candidate->setEndereco($dados['endereco']);
            $candidate->setBairro($dados['bairro']);
            $candidate->setCidade($dados['cidade']);
            $candidate->setEstado($dados['estado']);
            if(!empty($dados['nascimento'])){
                $candidate->setNascimento(DateTime::createFromFormat('Y-m-d', $dados['nascimento']));
            }        
            $this->em->persist($candidate);
            $this->em->flush();

            $msg = "Realizado atualização dos dados do candidato";

            return $msg;
        
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        

        // $candidate = $this->em->createQueryBuider(Candidate::class)
        //     ->findAndUpdate();

        // $qb = $em->createQueryBuilder();
            // $qb->select('u')
            // ->from('User', 'u')
            // ->where('u.id = ?1')
            // ->orderBy('u.name', 'ASC');
        // $job = $dm->createQueryBuilder(Job::class)
        // // Find the job
        // ->findAndUpdate()
        // ->field('in_progress')->equals(false)
        // ->sort('priority', 'desc')
    
        //  $query = $em->createQuery('SELECT u FROM MyProject\Model\User u WHERE u.age > 20');
        // $users = $query->getResult();

    }

    public function saveAction()
    {

        try {

            $msg = '';
            if ($this->request->isPost()) {

                $dados = $this->request->getPost();
                if(!empty($dados['id'])){
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

            return new ViewModel(['msg' => $msg]);
    } catch (Exception $e) {
        (new Log())->Err($e->getMessage());
        echo($e->getMessage());
    }
    }

    public function saveOrUpdateAction(){

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
   
    public function listAction()
    {
        try{


            if(!VerifySession::verify($_SESSION['token'])){
                $_SESSION['msg'] = 'Acesso negado';
                $this->redirect()->toRoute('adm', ['action' => 'index']);
        }
                    
            // $list = $this
            // ->em
            // ->createQuery('
            //     SELECT t, u
            //     FROM Application\Entity\Candidate\Candidate c
            //     JOIN Application\Entity\Candidate\Typing t
            //     ON c.id = t.candidate_id
            //     ');

            // $candidates = $this->em->getRepository(Candidate::class)->findAll(array(), array('id' => 'DESC'));
            
            $qb = $this->em->createQueryBuilder();
            // $qb->select('c')
            $qb->select('c.id', 'c.cpf', 'c.nome', 'c.social', 'c.nascimento', 'c.telefone', 'c.email', 'c.endereco', 'c.bairro', 'c.cidade', 'c.estado','c.cep', 't.tpm', 't.precisao', 't.seconds', 't.process', 't.inicio', 't.termino', 't.hits', 't.errors', 't.id as typing', 't.characters', 't.cancel', 't.justify')
            // $qb->select('c', 't')
                    ->from(Candidate::class, 'c')
                    ->join(Typing::class, 't', \Doctrine\ORM\Query\Expr\Join::WITH, 'c.id = t.candidate')
                    ->addOrderBy('t.process', 'DESC')               
                    ->addOrderBy('t.tpmp', 'DESC');
            $query = $qb->getQuery();
            $candidates = $query->getResult();


            $phrases = $this->em->getRepository(Phrase::class)->findAll(array(), array('modifiedDate' => 'DESC'));
            $this->em->flush($phrases);

            $users = $this->em->getRepository(User::class)->findAll(array(), array('modifiedDate' => 'DESC'));
            $this->em->flush($users);

            // $typing = $this->em->getRepository(Typing::class)->findOneBy(array('candidate' => $candidate[0]->getId()));

            // $qb = $this->em->createQueryBuilder('c');

        //     $queryBuilder
        //     ->select('id', 'name')
        //     ->from('users')
        //     ->where('email = ?')
        //     ->setParameter(0, $userInputEmail)
        // ;
        

            // $result = $qb->select("c")
            //     ->from(\Application\Entity\Candidate\Candidate::class, "c")
            //     ->leftJoin('c', 'typing', 't', 'c.id = t.candidate_id')->getQuery()->getResult();

                // ->where('c.username = :username')
                // ->setParameter('phone', $phone)
                // ->setParameter('username', $username);            
                // ->orderBy("T.queue", "DESC")
                // ->setMaxResults(1);

            // $result = $qb->getQuery()->getOneOrNullResult();

            return new ViewModel(["candidates" => $candidates, 'frases' => $phrases, 'users' => $users]);
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        
    }

    public function removeAction()
    {
        try{


            if(!VerifySession::verify($_SESSION['token'])){
                $_SESSION['msg'] = 'Acesso negado';
                $this->redirect()->toRoute('adm', ['action' => 'index']);
        }

            $msg = "";
            $id = $this->params()->fromRoute(('id'));
            $candidate = $this->em->getRepository(Candidate::class)->findOneBy([
                "id" => $id
            ]);
            if ($candidate) {
                $result = $this->em->remove($candidate);
                if(!$result){
                    $msg = "Candidato removido com sucesso!";
                } else {
                    $msg = 'Ops, não foi possível realizar a remoção. Favor informar Cod.: rm01';
                }
            } else {
                $msg = "Candidato não foi localizado";
            }
            $this->em->flush();
            return new ViewModel(['msg' => $msg]);
            // echo $this->url('blog'); // gives "/blog"
            // $id = (int) $this->params()->fromRoute('id' , '0')
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        

    }
   
    public function updateAction(){

        
        $id = $this->params()->fromRoute(('id'));
        $candidate = $this->em->getRepository(Candidate::class)->findOneBy([
            "id" => $id
        ]);
        // dd($candidate);
        return new ViewModel(['candidate' => ($candidate)]);
    }

    public function deleteAction(){
        try {

            if(!VerifySession::verify($_SESSION['token'])){
                $_SESSION['msg'] = 'Acesso negado';
                $this->redirect()->toRoute('adm', ['action' => 'index']);
        }

            $dados = $this->request->getPost();

            $candidate = $this->em->getRepository(Candidate::class)->findOneBy([
                "id" => $dados['id']
            ]);
            if ($candidate) {
                $result = $this->em->remove($candidate);
                if (!$result) {
                    $msg = "Candidato removido com sucesso!";
                } else {
                    $msg = 'Ops, não foi possível relizar a remoção. Favor informar Cod.: rm01';
                }
            } else {
                $msg = "Candidato não foi localizado";
            }
            $this->em->flush();

            $viewModel = new ViewModel(['msg' => $msg]);
            $viewModel->setTerminal(true);

            return $viewModel;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        
    }

     public function exitAction(){
        session_destroy();
        $this->redirect()->toRoute('adm', ['action' => 'index']);
    }

}


