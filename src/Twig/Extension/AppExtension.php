<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\MenuRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Yaml\Yaml;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $request;
    private $router;
    private $security;

    public function __construct(
        RequestStack $requestStack,
        RouterInterface $routerService,
        Security $securityService
    ) {
        $this->request = $requestStack;
        $this->router = $routerService;
        $this->security = $securityService;
    }

    public function getUserLogged()
    {
        return $this->security->getUser();
    }

    public function getFilters(): array
    {
        return [
            // If your filter generates SAFE HTML, you should add a third
            // parameter: ['is_safe' => ['html']]
            // Reference: https://twig.symfony.com/doc/3.x/advanced.html#automatic-escaping
            new TwigFilter('menu', [MenuRuntime::class, 'doSomething']),
        ];
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('menu', [$this, 'getMenu']),
        ];
    }

    public function getMenu()
    {
        $html = "";
        // if ($this->getUserLogged() != null) {
        $content = Yaml::parseFile('../config/menu.yaml');
        $html = $this->menuConstructor($content);
        // }
        return $html;
    }

    public function menuConstructor($items)
    {
        $routeName = $this->request->getCurrentRequest()->attributes->get('_route');
        $html = "";
        foreach ($items as $key => $item) {
            $tieneAcceso = false;
            $array_roles = is_null($item['roles']) ? [] : array_map('strtoupper', $item['roles']);
            // $roles = array_intersect($array_roles, $this->getUserLogged()->getRoles());
            foreach ($array_roles as $rol) {
                if ($this->security->isGranted($rol)) {
                    $tieneAcceso = true;
                }
            }
            // if (count($roles) > 0 || count($array_roles) == 0) {
            if ($tieneAcceso || count($array_roles) == 0) {
                $path = "";
                $target = "";
                $arrow = "";
                $submenu = "";
                $title = $key;
                $icon = $item['icon'];
                $empty_submenu = false;
                if (!empty($item['route'])) {
                    $active = strpos($routeName, $item['route']) !== false && strpos($routeName, $item['route']) == 0  ? "active" : "";
                }
                if (!empty($item['target'])) {
                    $target = "target='" . $item['target'] . "'";
                }
                if ($item['path'] != "") {
                    $path = $this->router->generate($item['path']);
                } elseif (!empty($item['custom_path'])) {
                    $path = $item['custom_path'];
                } else {
                    $path = "javascript:void(0)";
                }
                if (isset($item['submenu'])) {
                    $submenu = $this->subMenuConstructor($item['submenu']);
                    if (empty($submenu)) {
                        $empty_submenu = true;
                    }
                    $submenu = "<ul class='menu-submenu'>" . $submenu . "</ul>";
                    $active = strpos($submenu, 'active') !== false ? "active" : "";
                    $arrow = $active != "" ? "<span class='arrow open'></span>" : "<span class='arrow'></span>";
                }

                if ($empty_submenu === false) {
                    $html .= "<li class='menu-item menu-item-submenu " . $active . "' aria-haspopup='true' data-menu-toggle='hover'>";
                    $html .=    "<a href='" . $path . "' " . $target . " class='menu-link menu-toggle'>";
                    $html .=        "<i class='" . $icon . " svg-icon menu-icon'></i>";
                    $html .=        "<span class='menu-text'> " . $title . "</span>";
                    $html .=        $arrow;
                    $html .=        "<i class='menu-arrow'></i>";
                    $html .=    "</a>";
                    $html .=    $submenu;
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }

    public function subMenuConstructor($items)
    {
        $routeName = $this->request->getCurrentRequest()->attributes->get('_route');

        $html = "";
        foreach ($items as $key => $item) {
            $acceso = false;
            $array_roles = is_null($item['roles']) ? [] : array_map('strtoupper', $item['roles']);
            // $roles = array_intersect($array_roles, $this->getUserLogged()->getRoles());

            foreach ($array_roles as $rol) {
                if ($this->security->isGranted($rol)) {
                    $acceso = true;
                }
            }
            // if (count($roles) > 0 || count($array_roles) == 0) {
            if ($acceso || count($array_roles) == 0) {
                if (strpos($item['route'], '_') !== false) {
                    $arr = array($routeName);
                } else {
                    $arr = explode("_", $routeName, 2);
                }
                $path = "";
                $title = $key;
                $active = $arr[0] == $item['route'] ? "active" : "";
                if ($item['path'] != "") {
                    $path = $this->router->generate($item['path']);
                } else {
                    $path = "javascript:void(0)";
                }

                /* Sub menu nivel 2 */
                $target = "";
                $arrow = "";
                $submenu = "";
                $empty_submenu = false;

                $active2 = "";

                if (isset($item['submenu'])) {
                    $submenu = $this->subMenuConstructor($item['submenu']);
                    if (empty($submenu)) {
                        $empty_submenu = true;
                    }
                    $submenu = "<ul class='menu-submenu'>" . $submenu . "</ul>";
                    $active2 = strpos($submenu, 'active') !== false ? "active" : "";
                    $arrow = $active2 != "" ? "<span class='arrow open'></span>" : "<span class='arrow'></span>";
                }

                if ($empty_submenu === false) {
                    $html .= "<li class='menu-item menu-item-submenu " . $active . "' aria-haspopup='true' data-menu-toggle='hover'>";
                    $html .=    "<a href='" . $path . "' " . $target . " class='menu-link menu-toggle'>";
                    $html .=        "<i class='menu-bullet menu-bullet-line'>";
                    $html .=            "<span></span>";
                    $html .=        "</i>";
                    $html .=        "<span class='menu-text'>" . $title . "</span>";
                    $html .=        "<i class='menu-arrow'></i>";
                    $html .=    "</a>";
                    $html .=    $submenu;
                    $html .= "</li>";
                } else {
                    $html .= "<li class='menu-item " . $active . "'  aria-haspopup='true'>";
                    $html .=    "<a href='" . $path . "' class='menu-link'>";
                    $html .=        "<i class='menu-bullet menu-bullet-line'>";
                    $html .=            "<span></span>";
                    $html .=        "</i>";
                    $html .=        "<span class='menu-text'>" . $title . "</span>";
                    $html .=    "</a>";
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
