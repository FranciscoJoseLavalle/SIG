<?php

namespace App\Twig\Extension;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Yaml\Yaml;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class MenuExtension extends AbstractExtension
{
    private $request;
    private $router;

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
            new TwigFilter('menu', [$this, 'getMenu'])
        ];
    }

    public function getMenu()
    {
        $html = "";
        if ($this->getUserLogged() != null) {
            $content = Yaml::parseFile('../config/menu.yaml');
            $html = $this->menuConstructor($content);
        }
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
                    $submenu = "<ul class='sub-menu'>" . $submenu . "</ul>";
                    $active = strpos($submenu, 'active') !== false ? "active" : "";
                    $arrow = $active != "" ? "<span class='arrow open'></span>" : "<span class='arrow'></span>";
                }

                if ($empty_submenu === false) {
                    $html .= "<li class='nav-item " . $active . "'>";
                    $html .=    "<a href='" . $path . "' " . $target . " class='nav-link nav-toggle'>";
                    $html .=        "<i class='" . $icon . "'></i>";
                    $html .=        "<span class='title'> " . $title . "</span>";
                    $html .=        $arrow;
                    $html .=        "<span class='selected'></span>";
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
                    $submenu = "<ul class='sub-menu'>" . $submenu . "</ul>";
                    $active2 = strpos($submenu, 'active') !== false ? "active" : "";
                    $arrow = $active2 != "" ? "<span class='arrow open'></span>" : "<span class='arrow'></span>";
                }

                if ($empty_submenu === false) {
                    $html .= "<li class='nav-item " . $active . "'>";
                    $html .=    "<a href='" . $path . "' " . $target . " class='nav-link nav-toggle'>";
                    $html .=        "<span class='title'>" . $title . "</span>";
                    $html .=        $arrow;
                    $html .=        "<span class='selected'></span>";
                    $html .=    "</a>";
                    $html .=    $submenu;
                    $html .= "</li>";
                } else {
                    $html .= "<li class='nav-item " . $active . "'>";
                    $html .=    "<a href='" . $path . "' class='nav-link'>";
                    $html .=        "<span class='title'>" . $title . "</span>";
                    $html .=    "</a>";
                    $html .= "</li>";
                }
            }
        }
        return $html;
    }
}
