<?php

namespace App\Datatables;

use App\Entity\User;
use Sg\DatatablesBundle\Datatable\AbstractDatatable;
use Sg\DatatablesBundle\Datatable\Column\ActionColumn;
use Sg\DatatablesBundle\Datatable\Column\BooleanColumn;
use Sg\DatatablesBundle\Datatable\Column\Column;
use Sg\DatatablesBundle\Datatable\Column\DateTimeColumn;
use Sg\DatatablesBundle\Datatable\Column\MultiselectColumn;
use Sg\DatatablesBundle\Datatable\Column\VirtualColumn;
use Sg\DatatablesBundle\Datatable\Editable\SelectEditable;
use Sg\DatatablesBundle\Datatable\Editable\TextEditable;
use Sg\DatatablesBundle\Datatable\Filter\DateRangeFilter;
use Sg\DatatablesBundle\Datatable\Filter\NumberFilter;
use Sg\DatatablesBundle\Datatable\Filter\SelectFilter;
use Sg\DatatablesBundle\Datatable\Filter\TextFilter;
use Sg\DatatablesBundle\Datatable\Style;

/**
 * Class UserTestDatatable
 *
 * @package AppBundle\Datatables
 */
class UserDatatableTest extends AbstractDatatable
{
    /**
     * {@inheritdoc}
     */
    public function getLineFormatter()
    {
        $formatter = function ($row) {
            $row['test'] = 'Post from ' . $row['createdBy']['username'];

            return $row;
        };

        return $formatter;
    }

    /**
     * {@inheritdoc}
     */
    public function buildDatatable(array $options = array())
    {
        $this->ajax->set(array(
            // send some extra example data
            'data' => array('data1' => 1, 'data2' => 2),
            // cache for 10 pages
            'pipeline' => 10
        ));

        $this->options->set(array(
            'classes' => Style::BOOTSTRAP_3_STYLE,
            'stripe_classes' => ['strip1', 'strip2', 'strip3'],
            'individual_filtering' => true,
            'individual_filtering_position' => 'head',
            'order' => array(array(0, 'asc')),
            'order_cells_top' => true,
            //'global_search_type' => 'gt',
            'search_in_non_visible_columns' => true,
        ));

        $users = $this->em->getRepository(User::class)->findAll();

        $this->columnBuilder
            // ->add('id', Column::class, array(
            //     'title' => 'Numero',
            //     'searchable' => true,
            //     'orderable' => true,
            //     'filter' => array(
            //         TextFilter::class,
            //         array(
            //             'classes' => 'form-control input-sm input-inline'
            //         )
            //     ),
            //     'type_of_field' => 'string',
            //     'width' => '50'
            // ))
            ->add('id', Column::class, array(
                'title' => 'Id',
                'searchable' => true,
                'orderable' => true,
                'filter' => array(NumberFilter::class, array(
                    'classes' => 'test1 test2',
                    'search_type' => 'eq',
                    'cancel_button' => true,
                    'type' => 'number',
                    'show_label' => true,
                    'datalist' => array('3', '50', '75')
                )),
            ))
            ->add('visible', BooleanColumn::class, array(
                'title' => 'Visible',
                'searchable' => true,
                'orderable' => true,
                'true_label' => 'Yes',
                'false_label' => 'No',
                'default_content' => 'Default Value',
                'true_icon' => 'glyphicon glyphicon-ok',
                'false_icon' => 'glyphicon glyphicon-remove',
                'filter' => array(SelectFilter::class, array(
                    'classes' => 'test1 test2',
                    'search_type' => 'eq',
                    'multiple' => true,
                    'select_options' => array(
                        '' => 'Any',
                        '1' => 'Yes',
                        '0' => 'No'
                    ),
                    'cancel_button' => true,
                )),
                'editable' => array(SelectEditable::class, array(
                    'source' => array(
                        array('value' => 1, 'text' => 'Yes'),
                        array('value' => 0, 'text' => 'No'),
                        array('value' => null, 'text' => 'Null')
                    ),
                    'mode' => 'inline',
                    //'pk' => 'cid',
                    'empty_text' => '',
                )),
            ))
            ->add('title', Column::class, array(
                'title' => 'Title',
                'searchable' => true,
                'orderable' => true,
                'filter' => array(SelectFilter::class, array(
                    'multiple' => true,
                    'cancel_button' => true,
                    'select_search_types' => array(
                        '' => null,
                        '2' => 'like',
                        '1' => 'eq',
                        'send_isNull' => 'isNull',
                        'send_isNotNull' => 'isNotNull'
                    ),
                    'select_options' => array(
                        '' => 'Any',
                        '2' => 'Title with the digit 2',
                        '1' => 'Title with the digit 1',
                        'send_isNull' => 'is Null',
                        'send_isNotNull' => 'is not Null'
                    ),
                )),
                'editable' => array(TextEditable::class, array(
                    //'pk' => 'cid',
                )),
                'type_of_field' => 'integer', // If the title consists only of digits.
                /*
                'add_if' => function() {
                    return $this->authorizationChecker->isGranted('ROLE_USER');
                },
                */
            ))
            ->add('test', VirtualColumn::class, array(
                'title' => 'Test virtual',
                'searchable' => true,
                'orderable' => true,
                'order_column' => 'createdBy.username', // use the 'createdBy.username' column for ordering
                'search_column' => 'createdBy.username', // use the 'createdBy.username' column for searching
            ))
            // ->add('createdBy.username', Column::class, array(
            //     'title' => 'Created by',
            //     'searchable' => true,
            //     'orderable' => true,
            //     'filter' => array(SelectFilter::class, array(
            //         'select_options' => array('' => 'All') + $this->getOptionsArrayFromEntities($users, 'username', 'username'),
            //         'search_type' => 'eq'
            //     ))
            // ))
            // ->add('comments.title', Column::class, array(
            //     'title' => 'Comments',
            //     'data' => 'comments[,].title',
            //     'searchable' => true,
            //     'orderable' => true,
            // ))
            ->add(null, ActionColumn::class, array(
                'title' => 'Actions',
                'start_html' => '<div class="start_actions">',
                'end_html' => '</div>',
                'actions' => array(
                    array(
                        'route' => 'post_show',
                        'label' => 'Show Posting',
                        'route_parameters' => array(
                            'id' => 'id',
                            '_format' => 'html',
                            '_locale' => 'en'
                        ),
                        'render_if' => function ($row) {
                            return $row['createdBy']['username'] === 'user' && $this->authorizationChecker->isGranted('ROLE_USER');
                        },
                        'attributes' => array(
                            'rel' => 'tooltip',
                            'title' => 'Show',
                            'class' => 'btn btn-primary btn-xs',
                            'role' => 'button'
                        ),
                        'start_html' => '<div class="start_show_action">',
                        'end_html' => '</div>',
                    )
                )
            ));
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
