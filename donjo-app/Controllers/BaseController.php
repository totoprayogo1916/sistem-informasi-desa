<?php

namespace App\Controllers;

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
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;
    protected $header_model;
    protected $config_model;
    protected $Config;
    protected $first_keluarga_m;
    protected $first_m;
    protected $first_artikel_m;
    protected $first_gallery_m;
    protected $kategori_model;
    protected $first_menu_m;
    protected $first_penduduk_m;
    protected $penduduk_model;
    protected $surat_model;
    protected $surat_keluar_model;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        $this->header_model = model('header_model');
        $this->config_model = model('config_model');
        $this->Config = model('Config');
        $this->first_keluarga_m = model('first_keluarga_m');
        $this->first_m = model('first_m');
        $this->first_artikel_m = model('first_artikel_m');
        $this->first_gallery_m = model('first_gallery_m');
        $this->kategori_model = model('KategoriModel');
        $this->first_menu_m = model('first_menu_m');
        $this->first_penduduk_m = model('first_penduduk_m');
        $this->penduduk_model = model('penduduk_model');
        $this->surat_model = model('surat_model');
        $this->surat_keluar_model = model('surat_keluar_model');
    }
}
