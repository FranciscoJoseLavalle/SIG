<?php

namespace App\Datatables;

use App\Entity\User;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Style;

/**
 * Class UserDatatable
 *
 * @package App\Datatable
 */
class UserDatatable extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        return function ($row) {
            return $row;
        };
    }

    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this
            ->features
            ->set(array(
                'processing' => true
            ));

        $this
            ->ajax
            ->set(array(
                'pipeline' => 10
            ));

        $this
            ->options
            ->set(array(
                'classes' => Style::BOOTSTRAP_3_STYLE,
                'stripe_classes' => [
                    'strip1',
                    'strip2',
                    'strip3'
                ],
                'individual_filtering' => true,
                'individual_filtering_position' => 'head',
                'order' => array(
                    array(1, 'asc')
                ),
                'order_cells_top' => true,
                'search_in_non_visible_columns' => true
            ));

        $this->language->set(
            array(
                'language' => 'es'
            )
        );

        $this
            ->columnBuilder
            ->add('id', Column::class, array(
                'title' => 'ID',
                'searchable' => true,
                'orderable' => true,
                'filter' => array(
                    TextFilter::class,
                    array(
                        'classes' => 'form-control input-sm input-inline'
                    )
                ),
                'type_of_field' => 'string',
                'width' => '50'
            ))
            ->add('email', Column::class, array(
                'title' => 'Email',
                'searchable' => true,
                'orderable' => true,
                'filter' => array(
                    TextFilter::class,
                    array(
                        'classes' => 'form-control input-sm input-inline'
                    )
                ),
                'type_of_field' => 'integer',
            ))
            ->add(
                null,
                ActionColumn::class,
                array(
                    'title' => '',
                    'start_html' => '<div class="start_actions text-center">',
                    'end_html' => '</div>',
                    'actions' => array(
                        array(
                            'route' => 'app_user_show',
                            'label' => null,
                            'icon' => "fa fa-eye",
                            'route_parameters' => array(
                                'id' => 'id'
                            ),
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Mostrar',
                                'class' => 'btn light',
                                'role' => 'button'
                            )
                        ),
                        array(
                            'route' => 'app_user_edit',
                            'label' => null,
                            'icon' => "fa fa-pencil-square-o",
                            'route_parameters' => array(
                                'id' => 'id'
                            ),
                            'attributes' => array(
                                'rel' => 'tooltip',
                                'title' => 'Editar',
                                'class' => 'btn dark',
                                'role' => 'button'
                            )
                        ),
                        array(
                            'label' => null,
                            'icon' => "glyphicon glyphicon-trash",
                            'button' => true,
                            'button_value_prefix' => true,
                            'attributes' => function ($row) {
                                return array(
                                    'title' => 'Eliminar',
                                    'class' => 'btn btn-danger remover',
                                    'role' => 'button',
                                    'data-toggle' => 'modal',
                                    'data-id' => $row["id"],
                                    'data-target' => '#deleteModal'
                                );
                            }
                        )
                    )
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity()
    {
        return 'App\Entity\User';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'user_datatable';
    }
}
