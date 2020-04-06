<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Genre as EntityCrud;
use App\Controller\Admin\CrudController;

class GenreController extends CrudController
{
    private $entityName = 'Genre';
    private $entityLabel = 'Género';
    private $routeEdit = 'admin_genre_edit';
    private $routeDelete = 'admin_genre_delete';
    private $parameterId = 'idGenre';

    /**
     * @Route("genero/", name="admin_genre_list")
     */
    public function list(Request $request){
        $entities =  $this->getDoctrine()->getRepository(EntityCrud::class)->findAll();

        $table_conf = ['columns' => [
                        ['header_label' => 'Género', 'header_alignment' => 'left', 'field' => 'genre', 'data_alignment' => 'left'], 
                        ['header_label' => 'Activo', 'header_alignment' => 'center', 'field' => 'active', 'data_alignment' => 'center']
                       ], 
                       'cardinal' => true,
                       'new_button' => ['label' => 'Agregar ' . $this->entityLabel, 'route' =>  $this->routeEdit],
                       'actions' => [
                        'edit' => ['label' => 'Editar ' . $this->entityLabel, 
                                   'route' => $this->routeEdit, 
                                   'name_id' => $this->parameterId, 
                                   'button_class' => 'btn-success', 
                                   'icon_class' => 'fa fa-edit'
                                  ],
                        'delete' => ['label' => 'Eliminar ' . $this->entityLabel, 
                                     'route' => $this->routeDelete, 
                                     'name_id' => $this->parameterId, 
                                     'button_class' => 'btn-danger', 
                                     'icon_class' => 'fa fa-times'
                                    ]
                       ]
                      ];

        return $this->render('Admin/' . $this->entityName . '/list.html.twig', ['table_conf' => $table_conf, 'elements' => $entities]);
        return $this->render('Admin/Genre/list.html.twig');
    }

    /**
     * @Route("genero/editar/{idGenre}", 
     *         defaults={"idGenre"=null}, 
     *         requirements={"idGenre"="\d+"}, 
     *         name="admin_genre_edit"
     * )
     */
    public function edit(Request $request, $idGenre){

    }

    /**
     * @Route("genero/eliminar/{idGenre}", 
     *         defaults={"idGenre"=null}, 
     *         requirements={"idGenre"="\d+"}, 
     *         name="admin_genre_delete"
     * )
     */
    public function delete(Request $request, $idGenre){
        
    }
}