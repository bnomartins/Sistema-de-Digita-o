<?php
declare(strict_types=1);

namespace Application\Controller;

use Application\Custom\Cript;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;
use Application\Custom\Log;
use Application\Custom\VerifySession;
use Application\Entity\Candidate\User;
use DateTime;

class UserController extends AbstractActionController
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

    private function save()
    {
        try {
                //code...
            $dados = $this->request->getPost();
            $user = new User();
            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado, nivel, senha1
            $user->setNome($dados['nome']);
            $user->setSocial($dados['social']);
            $user->setCpf($dados['cpf']);
            if(!empty($dados['nascimento'])){
                $user->setNascimento(DateTime::createFromFormat('Y-m-d', $dados['nascimento']));
            }  
            $user->setTelefone($dados['telefone']);
            $user->setEmail($dados['email']);
            $user->setCep($dados['cep']);
            $user->setEndereco($dados['endereco']);
            $user->setBairro($dados['bairro']);
            $user->setCidade($dados['cidade']);
            $user->setEstado($dados['estado']);
            $user->setNivel($dados['nivel']);

            if(!empty($dados['senha1'])){
                $senha = (new Cript())->cript($dados['senha1']);
                $user->setSenha($senha);
            }

            $query = $this->em->createQuery('SELECT u FROM Application\Entity\Candidate\User u WHERE u.cpf = :cpf');
            
            $query->setParameter('cpf', $dados['cpf']);
            $users = $query->getResult();

            $msg = "";
            if(empty($users)){
                $result = $this->em->persist($user);
        
                if (!$result) {
                    $msg = "Dados inseridos com sucesso";
                } else {
                    $msg = "Não foi possível realizar a inclusão";
                }
                $this->em->flush();
            } else {
                $msg = "Usuário já cadastrada";
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
            $user = $this->em->getRepository(User::class)->findOneBy([
                "id" => $id
            ]);
            // name social cpf nascimento telefone email

            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado
            $user->setNome($dados['nome']);
            $user->setSocial($dados['social']);
            $user->setCpf($dados['cpf']);

            if(!empty($dados['nascimento'])){
                $user->setNascimento(DateTime::createFromFormat('Y-m-d', $dados['nascimento']));
            }     

            $user->setTelefone($dados['telefone']);
            $user->setEmail($dados['email']);
            $user->setCep($dados['cep']);
            $user->setEndereco($dados['endereco']);
            $user->setBairro($dados['bairro']);
            $user->setCidade($dados['cidade']);
            $user->setEstado($dados['estado']);
            $user->setNivel($dados['nivel']);

            if(!empty($dados['senha1'])){
                $senha = (new Cript())->cript($dados['senha1']);
                $user->setSenha($senha);
            }
            $this->em->persist($user);
            $this->em->flush();

            $msg = "Realizado atualização";

            return $msg;
        
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



    public function restrictAction(){

        try {

            if ($this->request->isPost()) {
                $dados = $this->request->getPost();
                $msg = '';
                // Usuário e senha conferem

                if ($this->authentication($dados['cpf'], $dados['senha'])) {
                    
                    // $viewModel = new ViewModel();
                    // $viewModel->setTemplate('adm/list');
                    $this->redirect()->toRoute("adm", ["action" => "list"]);

                } else {
                    $senha = (new Cript())->cript('digitação@123');
                    // dd($senha);
            
                    $msg = "Usuário e/ou senha não conferem".$senha;
                    // $viewModel = new ViewModel();
                    // $viewModel->setTemplate('user/index');
                    $_SESSION['msg'] = $msg;
                    return $this->redirect()->toRoute("user", ["action" => "index", "msg" => 'teste']);

                    // return $this->redirect()->toRoute('my/route', [], ['method' => 'GET', 'query' => $params));
                }

            } else {
                $msg = "Acesso Negado";
                $_SESSION['msg'] = $msg;

                // $viewModel = new ViewModel();
                // $viewModel->setTemplate('user/index');
                $this->redirect()->toRoute("user", ["action" => "index", "msg" => $msg]);
            }    
            
        } catch (Exception $e) {
            print($e->getMessage());
            (new Log())->Err($e->getMessage());
        }
    }

    public function authentication($cpf, $senha): bool{
        try {
            $user = $this->em->getRepository(User::class)->findBy(array('cpf' => $cpf));
            $auth = false;
            if (!empty($user)) {
                $senhaUser = (new Cript())->decript($user[0]->getSenha());
                if($senhaUser == $senha){

                    $_SESSION['user']['nome'] = $user[0]->getNome();
                    $_SESSION['user']['email'] = $user[0]->getEmail();
                    $_SESSION['user']['nivel'] = $user[0]->getNivel();
                    $_SESSION['user']['id'] = $user[0]->getId();
                    $_SESSION['token'] = VerifySession::generate();
                   
                    $auth = true;
                }
            } else {
                $auth = false;
            }
            return $auth;
            //code...
        } catch (Exception $e) {
            echo($e->getMessage());
            (new Log())->Err($e->getMessage());
        }            
    }

    public function removeAction()
    {
        try{
            $msg = "";
            $dados = $this->request->getPost();
            $usuario = $this->em->getRepository(User::class)->findOneBy([
                "id" => $dados['id']
            ]);
            if (!empty($usuario)) {
                $result = $this->em->remove($usuario);
                if(!$result){
                    $msg = "Usuário removido com sucesso!";
                } else {
                    (new Log())->Err('Ops, não foi possível realizar a remoção. Favor informar Cod.: usrm01');
                    $msg = 'Ops, não foi possível realizar a remoção. Favor informar Cod.: usrm01';
                }
            } else {
                $msg = "Usuário não foi localizado";
            }
            $this->em->flush();
            $viewModel = new ViewModel(['msg' => $msg]);
            $viewModel->setTerminal(true);
            return $viewModel;
            // echo $this->url('blog'); // gives "/blog"
            // $id = (int) $this->params()->fromRoute('id' , '0')
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        
     
    }
    
}
