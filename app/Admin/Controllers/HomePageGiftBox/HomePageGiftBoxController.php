<?php

namespace App\Admin\Controllers\HomePageGiftBox;

use App\Http\Controllers\Controller;

use App\Models\HomePageGiftBox;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;


class HomePageGiftBoxController extends Controller
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
            // ->title('title')
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
        $grid = new Grid(new HomePageGiftBox);

        $grid->actions(function ($actions) use ($grid) {
            $actions->disableView();
        });

        $grid->id('ID')->sortable();
        $grid->small_image_en('small_image_en')->image();
        $grid->small_image_ar('small_image_ar')->image();

        $states = [
            'on' => ['value' => 0, 'text' => 'no', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => 'yes', 'color' => 'success'],
        ];

        $grid->status('status')->switch($states);

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
        $show = new Show(HomePageGiftBox::findOrFail($id));

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
        $form = new Form(new HomePageGiftBox);

        $form->display('id', 'ID');
        $form->image('small_image_ar', 'small_image_ar ')->move(Carbon::now()->year . '/home_page_gift_box')->uniqueName();
        $form->image('large_image_ar', 'large_image_ar ')->move(Carbon::now()->year . '/home_page_gift_box')->uniqueName();
        $form->image('small_image_en', 'small_image_en ')->move(Carbon::now()->year . '/home_page_gift_box')->uniqueName();
        $form->image('large_image_en', 'large_image_en ')->move(Carbon::now()->year . '/home_page_gift_box')->uniqueName();

        $form->number('sort_order')->default(1);
        $form->radio('status', 'Active')->options(['1' => 'yes', '0' => 'no']);
        $form->url('url');
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');

        return $form;
    }
}
