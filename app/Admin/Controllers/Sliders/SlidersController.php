<?php

namespace App\Admin\Controllers\Sliders;

use App\Http\Controllers\Controller;

use App\Models\Sliders;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Carbon\Carbon;
use Encore\Admin\Form\Builder;

class SlidersController extends Controller
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
        $grid = new Grid(new Sliders);

        $grid->actions(function ($actions) use ($grid) {
            $actions->disableView();
        });
        
        $grid->id('ID')->sortable();
        $grid->title_en('Title');

        $states = [
            'on' => ['value' => 0, 'text' => 'disabled', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => 'enabled', 'color' => 'success'],

        ];
        $grid->status('Active')->switch($states);


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
        $show = new Show(Sliders::findOrFail($id));

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
    
/*    protected function store()
        {
            $request = request()->all();
            $form = $this->form();
            $slider = new Sliders();
            $resourcesPath = $form->resource( 0 );
            $slider->title_en = $request['title_en'];
            $slider->title_ar = $request['title_ar'];
            $slider->status = $request['status']=='false' ? 0 : 1;
            $slider->save();
            $file = $request['image'];
            $file_name = time() . $file->getClientOriginalName();                      
            $file_path = 'uploads/'.Carbon::now()->year.'/sliders/'.$slider->id;
            $file->move($file_path, $file_name);
            $slider->image = str_replace('uploads/', '', $file_path).'/'.$file_name;
            $slider->Save();
            $url = request( Builder::PREVIOUS_URL_KEY ) ?: $resourcesPath;
            admin_toastr( trans( 'admin.save_succeeded' ) );
            return redirect( $url );
        }
	public function update( $id ) {
                $request = request()->all();
		$form = $this->form();
                $slider = Sliders::find($id);
                $slider->title_en = $request['title_en'];
                $slider->title_ar = $request['title_ar'];
                $slider->status = $request['status']=='false' ? 0 : 1;
                $slider->save();
                $file = $request['image'];
                $file_name = time() . $file->getClientOriginalName();                      
                $file_path = 'uploads/'.Carbon::now()->year.'/sliders/'.$slider->id;
                $file->move($file_path, $file_name);
                $slider->image = str_replace('uploads/', '', $file_path).'/'.$file_name;
                $slider->Save();
                $url = request( Builder::PREVIOUS_URL_KEY ) ?: $resourcesPath;
                admin_toastr( trans( 'admin.save_succeeded' ) );
                return redirect( $url );
        }
 * 
 */
        
    protected function form()
    {
        $form = new Form(new Sliders);

        $form->display('id', 'ID');
        $form->text('title_en', 'Title En')->required();;
        $form->text('title_ar', 'Title Ar')->required();;
        $form->text('link', 'Link');
        $form->image('image', 'Image ')->move(Carbon::now()->year . '/sliders')->uniqueName()->required();;
//        $form->radio('status', 'Status')->options(['1' => 'Avtive', '0'=> 'Not Active'])->default('1');
        $states = [
            'on' => ['value' => 0, 'text' => 'disabled', 'color' => 'danger'],
            'off' => ['value' => 1, 'text' => 'enabled', 'color' => 'success'],

        ];
//        $form->status()->switch($statesss);

        $form->switch('status', 'Active')->states($states);
//        $form->status()->switch($states);
        $form->display('created_at', 'Created At');
        $form->display('updated_at', 'Updated At');
        $form->saved(function ($form) {
            if (request('image')) {
                $oldPath = $form->model()->image;
                $newPath = Carbon::now()->year . '/sliders/' . $form->model()->id . '/' . $this->afterString(Carbon::now()->year . '/sliders/', $form->model()->image);

                $form->model()->image = $newPath;
                $form->model()->save();

                $this->moveFile($oldPath, $newPath);
            }
        });
        return $form;
    }
}
