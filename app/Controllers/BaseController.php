<?php

namespace App\Controllers;

use App\Models\BImbinganModel;
use App\Models\DetailBimbinganModel;
use App\Models\DosenModel;
use App\Models\Jabatan;
use App\Models\Modeldosen;
use App\Models\Modelmahasiswa;
use App\Models\Prodi;
use App\Models\ProposalModel;
use App\Models\SkripsiModel;
use App\Models\UsersModel;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = ['form', 'url'];

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->db      = \Config\Database::connect();
        $this->session = \Config\Services::session();

        $this->mhs = new Modelmahasiswa;
        $this->prodi = new Prodi;
        $this->dsn = new Modeldosen;
        $this->jbt = new Jabatan;
        $this->ProposalModel = new ProposalModel();
        $this->BimbinganModel = new BimbinganModel();
        $this->DetailBimbinganModel = new DetailBimbinganModel();
        $this->UsersModel = new UsersModel;
    }
}
