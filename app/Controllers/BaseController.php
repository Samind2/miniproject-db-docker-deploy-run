<?php
/* Shaoransoft Developer */
namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\UsersModel;
use App\Models\EnrollModel;

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
    protected $helpers = [];

    protected $userLogged = [];

    private $styles = [
        'cdn' => [
            'https://fonts.googleapis.com/css2?family=Noto+Sans+Thai:wght@100;200;300;400;500;600;700;800;900&display=swap',
            'https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.css',
            'https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css',
            'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css',
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css',
        ],
        'local' => [
            'theme/styles.css',
            'theme/css.css',
            'summernote/summernote.min.css',
            'codemirror/codemirror.css',
            'codemirror/theme/tomorrow-night-eighties.css',
            'select2/select2.min.css',
            'select2/select2-bootstrap-5-theme.min.css',
            'fullcalendar/fullcalendar.main.css',
        ]
    ];

    private $scripts = [
        'cdn' => [
            'https://cdn.jsdelivr.net/npm/sweetalert2@11',
        ],
        'local' => [
            'jquery/jquery.min.js',
            'popperjs/popper.min.js',
            'bootstrap/bootstrap.min.js',
            'datatables/jquery.dataTables.min.js',
            'datatables/dataTables.bootstrap5.min.js',
            'datatables/dataTables.fixedColumns.min.js',
            'datatables/dataTables.config.js',
            'summernote/summernote.js',
            'summernote/lang/summernote-th-TH.js',
            'summernote/summernote.config.js',
            'codemirror/codemirror.js',
            'codemirror/mode/xml/xml.js',
            'codemirror/formatting.js',
            'select2/select2.min.js',
            'sweetalert2/sweetalert2.config.js',
            'fullcalendar/fullcalendar.core.min.js',
            'fullcalendar/fullcalendar.min.js',
            'fullcalendar/fullcalendar.bootstrap5.min.js',
            'fullcalendar/locales/th.js',
        ]
    ];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        // E.g.: $this->session = \Config\Services::session();
        if (session()->get('LOGGED_IN'))
        {
            $userLogged = (new UsersModel)->where('user_id', base64_decode(session()->get('UID')))->first();
            if (empty($userLogged))
                return redirect()->to('/signout');
            unset($userLogged['login_pwd']);
            $userLogged['pending_pay_alert'] = (new EnrollModel)->where([
                    'user_id' => $userLogged['user_id'],
                    'enroll.status' => 'PENDING_PAY'
                ])->countAllResults();
            $this->userLogged = $userLogged;
        }
    }

    protected function renderSuccess(String $viewName = 'Index', String $message = '', $redirect = '', Bool $renderNavbar = true, Bool $renderFooter = true) {
        return $this->render($viewName, ['success' => true, 'message' => $message, 'redirect' => $redirect], $renderNavbar, $renderFooter);
    }

    protected function renderError(String $viewName = 'Index', String $message = '', $redirect = '', Bool $renderNavbar = true, Bool $renderFooter = true) {
        return $this->render($viewName, ['success' => false, 'message' => $message, 'redirect' => $redirect], $renderNavbar, $renderFooter);
    }

    protected function render(String $viewName = 'Index', Array $data = [], Bool $renderNavbar = true, Bool $renderFooter = true) {
        if (session()->get('LOGGED_IN'))
            $data['UserLogged'] = $this->userLogged;
        $data['Layout'] = [
            'Header' => view('Shared/Header', array_merge($data, [
                'RenderStyles' => $this->renderStyles(),
                'RenderScripts' => $this->renderScripts()
            ])),
            'Navbar' => $renderNavbar ? view('Shared/Navbar', $data) : null,
            'Footer' => $renderFooter ? view('Shared/Footer', $data) : null,
            'Content' => view($viewName, $data),
        ];
        return view('Shared/Layout', $data);
    }

    protected function renderStyles(): string
    {
        $print = '';
        if (!empty($this->styles))
        {
            foreach ($this->styles as $key => $styles)
            {
                if (!empty($styles))
                {
                    foreach ($styles as $style)
                    {
                        $print .= '<link rel="stylesheet" href="'.($key === 'local' ? base_url().'/style/' : '').$style.'">';
                    }
                }
            }
        }
        return $print;
    }

    protected function renderScripts(): string
    {
        $print = '';
        if (!empty($this->scripts))
        {
            foreach ($this->scripts as $key => $scripts)
            {
                if (!empty($scripts))
                {
                    foreach ($scripts as $script)
                    {
                        $print .= '<script '.(is_array($script) ? urldecode(http_build_query($script, '"', ' ')) : 'src="'.($key === 'local' ? base_url().'/script/' : '').$script.'"').'></script>';
                    }
                }
            }
        }
        return $print;
    }
}
