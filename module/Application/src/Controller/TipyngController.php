<?php

declare(strict_types=1);

namespace Application\Controller;

use Application\Custom\Log;
use Application\Custom\VerifySession;
use Application\Entity\Candidate\Candidate;
use Application\Entity\Candidate\Phrase;
use Application\Entity\Candidate\Typing;
use DateTime;
use Doctrine\ORM\EntityManager;
use Exception;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;


class TipyngController extends AbstractActionController
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

    public function prepareAction()
    {
        try {
            
            $viewModel = new ViewModel();

            $dados = $this->request->getPost();
            if ($this->request->isPost()) {
                $candidate = $this->em->getRepository(Candidate::class)->findBy(array('cpf' => $dados['cpf']));
                
                // Se não tiver mais de 5 frases a página de teste será bloqueada
                $phrases = $this->em->getRepository(Phrase::class)->findAll();

                // Verifica se existe frases suficiente para iniciar o teste.
                $block = count($phrases);
                $this->em->flush();
                
                // Candidato já tem registro
                if (!empty($candidate)) {
                    $typing = $this->em->getRepository(Typing::class)->findBy(array('candidate' => $candidate[0]->getId(), 'process' => $dados['process']), array('id' => 'DESC'));
                    $this->em->flush();


                    // Não Existe teste com o mesmo com o mesmo processo seletivo - Envia para a página de teste
                    if (empty($typing)) {
                        $viewModel = new ViewModel(['candidate' => ($candidate[0]), 'typing' => ($typing), 'process' => $dados['process'], 'frases' => $phrases, 'block' => $block]);

                    // Existe teste
                    } else {
                        // O teste foi cancelado, então permitir que se faça outro
                        if ($typing[0]->getCancel() == true){
                            $viewModel = new ViewModel(['candidate' => ($candidate[0]), 'typing' => ($typing), 'process' => $dados['process'], 'frases' => $phrases, 'block' => $block]);
                        // Mostrar Resultado do teste
                        } else {
                            $viewModel = new ViewModel(['candidate' => ($candidate[0]), 'typing' => $typing[0]]);
                            $viewModel->setTemplate('application/tipyng/report'); 
                        }
                    }
                    return $viewModel;

                // Candidato não tem registro
                } else {
                    $newCandidate = new Candidate();
                    $newCandidate->setCpf($dados['cpf']);

                    $this->em->persist($newCandidate);

                    $phrases = $this->em->getRepository(Phrase::class)->findAll();

                    $this->em->flush();

                    $viewModel = new ViewModel(['candidate' => ($newCandidate), 'process' => $dados['process'], 'frases' => $phrases, 'block' => $block]);
                }

            } else {
                $viewModel = new ViewModel(['msg' => "Ação não permitida"]);
                $viewModel->setTemplate('application/adm/candidate');
            }

            return $viewModel;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        

    }

    public function registerAction(){
    // id, erros, acertos, caracteres, tpm, precisao, s, dtInicioTxt, dtFimTxt
    $msg = "";
        try {
            $dados = $this->request->getPost();
                $msg = '';
                $candidate = $this->em->getRepository(Candidate::class)->findBy(array('id' => $dados['id']));

                if(!empty($candidate)){

                    $typing = new Typing();
                    $typing->setCandidate($candidate[0]);
                    $typing->setTpm($dados['tpm']);
                    $typing->setTpmp($dados['tpmp']);
                    $typing->setErrors($dados['erros']);
                    $typing->setHits($dados['acertos']);
                    $typing->setCharacters($dados['caracteres']);
                    $typing->setPrecisao($dados['precisao']);
                    $typing->setSeconds($dados['s']);
                    $typing->setProcess($dados['process']);
                    // $typing->setInicio($dados['dtInicioTxt']);
                    // $typing->setTermino($dados['dtFimTxt']);
            
                    if (!empty($dados['dtInicioTxt'])) {
                        $typing->setInicio(DateTime::createFromFormat('Y-m-d H:i:s', $dados['dtInicioTxt']));
                    }
            
                    if (!empty($dados['dtFimTxt'])) {
                        $typing->setTermino(DateTime::createFromFormat('Y-m-d H:i:s', $dados['dtFimTxt']));
                    }
            
                    // $ticket->setRelationship(($data["typePerson"] == "I" ? $this->em->find(Relationship::class, $data["relationshipType"]) : null));
            
                    $this->em->persist($typing);
                    $this->em->flush();
            
                    $msg = "<strong>Teste finalizado. Veja o seu <a href='/adm/candidate'>resultado</a></strong>";
                } else {
                    $msg = 'Candidato não localizado';
                }


                $viewModel = new ViewModel(['msg' => $msg]);
                $viewModel->setTerminal(true);
                // $viewModel = new ViewModel(['msg' => $msg]);

                // $msg = 'Acesso negado';
                // $viewModel = new ViewModel(['msg' => $msg]);
                // $viewModel->setTemplate('tipyng/index');
                return $viewModel;
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo $e->getMessage();
        }
    }

    public function cancelAction(){

        try{


            if(!VerifySession::verify($_SESSION['token'])){
                $_SESSION['msg'] = 'Acesso negado';
                $this->redirect()->toRoute('adm', ['action' => 'index']);
            }

            $msg = '';
            $dados = $this->request->getPost();
            $typing = $this->em->getRepository(Typing::class)->findOneBy([
                "id" => $dados['test']
            ]);
            // name social cpf nascimento telefone email

            // id, nome, social, cpf, nascimento, telefone, email, cep, endereco, bairro, cidade, estado
            $typing->setJustify($dados['justify']);
            $typing->setCancel(true);

            $this->em->persist($typing);
            $this->em->flush();

            $msg = "Realizado cancelamento do teste de digitação";

            $viewModel = new ViewModel(['msg' => $msg]);
            $viewModel->setTerminal(true);
            return $viewModel;
        
        } catch (Exception $e) {
            (new Log())->Err($e->getMessage());
            echo($e->getMessage());
        }        
 
    
    }

}
