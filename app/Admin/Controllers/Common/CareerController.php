<?php

namespace App\Admin\Controllers\Common;

use App\Http\Controllers\Controller;


use App\Models\Careers;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Form\Builder;

class CareerController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            //            ->title('title')
            ->status('status')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')

            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Careers());

        //        $grid->actions(function ($actions) use ($grid) {
        //            $actions->disableCreateButton();
        //        });

        $grid->disableCreateButton();
        $grid->disableActions();

        $grid->id('ID')->sortable();
        $grid->first_name('First Name');
        $grid->email('Email');
        $grid->tel('Telephone');
        $grid->country()->title_en('Nationality');
        $grid->position('Position');
        //        $grid->attachment('Attachment');



        // The sixth column shows the released field, formatting the display output through the display($callback) method
        $grid->attachment('Attachment')->display(function ($attachment) {
            //            $url = \Storage::url('app'.$attachment);
            return $attachment = "<a target='_blank' href='/admin/download_file/$attachment'>Download</a>";
        });



        // The filter($callback) method is used to set up a simple search box for the table
        $grid->filter(function ($filter) {
            $filter->like('position', 'position');
            $filter->like('email', 'email');
            $filter->like('tel', 'tel');
            // Sets the range query for the created_at field
            $filter->between('created_at', 'Created Time')->datetime();
        });



        $grid->created_at('Created at');


        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Careers::findOrFail($id));

        $show->id('ID');

        $show->first_name('First Name');
        $show->email('Email');
        $show->tel('Telephone');
        $show->nationality('Nationality');
        $show->position('Position');
        $show->attachment('Attachment');


        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */



    protected function form()
    {
        $form = new Form(new Careers());



        return $form;
    }
}
