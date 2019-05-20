<?php

namespace App\Admin\Controllers\Pages;

use App\Http\Controllers\Controller;

use App\Models\Pages;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;

class PagesController extends Controller
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
            ->title('title')
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
        $grid = new Grid(new Pages);

        $grid->filter(function ($filter) {
            $filter->in('name_en', 'Title English')->multipleSelect(\App\Models\Pages::all()->pluck('name_en', 'name_en'));
        });
        
        $grid->actions(function ($actions) use ($grid) {
            $actions->disableView();
            $actions->disableDelete();
        });
        
        $grid->id('ID')->sortable();
        $grid->name_en('Title');

        $grid->created_at('Created at');
        $grid->updated_at('Updated at');

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
        $show = new Show(Pages::findOrFail($id));

        $show->id('ID');


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
        $form = new Form(new Pages);

        $form->display('id', 'ID');
        $form->display('slug', 'Slug');
        $form->text('name_en', 'Title En')->required();
        $form->textarea('description_en', 'Body En')->required();
        $form->text('name_ar', 'Title Ar')->required();
        $form->textarea('description_ar', 'Body Ar')->required();
        $form->image('image', 'Image')->move(Carbon::now()->year.'/pages')->uniqueName();


        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');
        // $form->saved(function ($form) {
        //     if (request('image')) {
        //         $oldPath = $form->model()->image;
        //         $newPath = Carbon::now()->year . '/pages/' . $form->model()->id . '/' . $this->afterString(Carbon::now()->year . '/pages/', $form->model()->image);

        //         $form->model()->image = $newPath;
        //         $form->model()->save();

        //         $this->moveFile($oldPath, $newPath);
        //     }
        // });
        return $form;
    }
}
