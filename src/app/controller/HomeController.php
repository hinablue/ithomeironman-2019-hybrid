<?php

namespace Ithomeironman2019\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class HomeController
{
     protected $container;
     protected $view;
     protected $config;
     protected $templateData = [];

     // constructor receives container instance
     public function __construct(ContainerInterface $container)
     {
          $this->container = $container;
          $this->view = $container->get('view');
          $this->config = $container->get('config');

          $vueStatic = $this->config['VUE_STATIC'];

          $jsFiles = [ 'main.js'];
          foreach (new \DirectoryIterator(ROOT . '/../public/' . $vueStatic['js']) as $file) {
               if ($file->isDot() || $file->getBasename() === '.DS_Store') {
                    continue;
               }
               if ($file->isFile()) {
                    $ext = pathinfo($file->__toString(), PATHINFO_EXTENSION);
                    if ($ext === 'js' && !preg_match('/^[0-9]+\.(.*)/i', $file->__toString())) {
                         if ($file->__toString() !== 'main.js') {
                              array_unshift(
                                   $jsFiles,
                                   $file->__toString()
                              );
                         }
                    }
               }
          }

          $cssFiles = ['main.css'];
          foreach (new \DirectoryIterator(ROOT . '/../public/' . $vueStatic['css']) as $file) {
               if ($file->isDot() || $file->getBasename() === '.DS_Store') {
                    continue;
               }
               if ($file->isFile()) {
                    $ext = pathinfo($file->__toString(), PATHINFO_EXTENSION);
                    if ($ext === 'css' && !preg_match('/^[0-9]+\.(.*)/i', $file->__toString())) {
                         if ($file->__toString() !== 'main.css') {
                              array_unshift(
                                   $cssFiles,
                                   $file->__toString()
                              );
                         }
                    }
               }
          }

          $this->templateData = [
               'title' => '',
               'keyword' => '',
               'description' => 'ITHome Iromman 2019 Hybrid App',
               'vueStatic' => $vueStatic,
               'jsFiles' => $jsFiles,
               'cssFiles' => $cssFiles
          ];
     }

     public function index(Request $request, Response $response, $args)
     {
          $this->templateData = array_merge(
               $this->templateData,
               [
                    'title' => 'HELLO HOMEPAGE',
                    'keyword' => 'Homepage'
               ]
          );
          return $this->view->render($response, 'index.twig', $this->templateData);
     }

     public function about(Request $request, Response $response, $args)
     {
          $this->templateData = array_merge(
               $this->templateData,
               [
                    'title' => 'ABOUT Page',
                    'keyword' => 'About'
               ]
          );
          return $this->view->render($response, 'about.twig', $this->templateData);
     }
}