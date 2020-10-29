<?php

namespace App\Http\Controllers;

use App\Models\Template;
use App\Traits\DudaApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    use DudaApi;

    private $templateModel;

    public function __construct(Template  $templateModel){
        $this->templateModel = $templateModel;
    }

    public function create(){
        /*$siteName = $this->createSite();
        echo "Site Criado: " . $siteName."<br />";*/

        //criando conta
        //$this->createCustomerAccount(); //chamar apenas uma vez para cada usuário, pode ser no primeiro login dele

        /*$this->grantAccountAccess($siteName);

        echo $this->getSSOLink(Auth::user()->email, $siteName, 'EDITOR')."<br />";*/


        //Listar Sites Criados
        //dd($this->getSitesByExternalId();

       // dd($this->getSites());

        //importar templates
        /*$templates = json_decode($this->getAllTemplates());
        $this->templateModel
            ->createOrUpdate($templates);*/


    }

    public function store()
    {

    }
}
