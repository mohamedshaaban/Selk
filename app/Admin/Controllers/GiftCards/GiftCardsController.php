<?php

namespace App\Admin\Controllers\GiftCards;

use App\Http\Controllers\Controller;

use App\Models\GiftCards;
use App\Models\PreviewGiftCards;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

use Carbon\Carbon;
use \Illuminate\Support\Facades\Request;
use Encore\Admin\Form\Builder;
use Illuminate\Support\Facades\File;
use App\Models\CardPrices;
use Illuminate\Support\Facades\Redirect;

class GiftCardsController extends Controller
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
        $grid = new Grid(new GiftCards);




        $grid->id('ID')->sortable();
        $grid->name_en('Title');
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
        $show = new Show(GiftCards::findOrFail($id));

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
    public function store()
    {
        $request = (object)request()->all();
        $form = $this->form();



        if ($request->is_preview == 1) {
            $card = new PreviewGiftCards();
        } else {
            $card = new GiftCards();
        }


        //            dd($newPath);
        $card->name_en = $request->name_en;
        $card->name_ar = $request->name_ar;
        $card->price = $request->price;
        $card->body_en = $request->body_en;
        $card->body_ar = $request->body_ar;
        $card->color = $request->color;
        $card->status = $request->status;
        $card->availability = $request->availability;
        $card->availability = $request->availability;
        $card->save();
        if ($request->image) {

            $image = $request->image;
            $imageName = Carbon::now()->year . '/giftcards/' . $card->id . '/' . time() . md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $path = public_path() . '/uploads/' . Carbon::now()->year . '/giftcards/' . $card->id;
            File::makeDirectory($path, $mode = 0777, true, true);
            $image->move($path, $imageName);
        }
        $card->image = $imageName;
        $card->update();
        $card->refresh();
        if (isset($request->cardprices) && $request->is_preview != 1) {
            foreach ($request->cardprices as $cardprice) {

                    $cardpric = new CardPrices();
                    $cardpric->card_id = $card->id;
                    $cardpric->amount = $cardprice['amount'];
                    $cardpric->save();
                }
        }

        if ($request->is_preview == 1) {
            $url = '/admin/preview_card/' . $card->id;
        } else {
            $resourcesPath = $form->resource(0);
            $url = request(Builder::PREVIOUS_URL_KEY) ?: $resourcesPath;
        }
        return Redirect::to($url);
    }

    public function update($id)
    {

        $request = (object)request()->all();
        $form = $this->form();



        if ($request->is_preview == 1) {
            $card =  PreviewGiftCards::find($id);
        } else {
            $card =  GiftCards::find($id);
        }


        //            dd($newPath);
        $card->name_en = $request->name_en;
        $card->name_ar = $request->name_ar;
        $card->price = $request->price;
        $card->body_en = $request->body_en;
        $card->body_ar = $request->body_ar;
        $card->color = $request->color;
        $card->status = $request->status;
        $card->availability = $request->availability;
        $card->availability = $request->availability;
        $card->save();
        if (isset($request->image)) {

            $image = $request->image;
            $imageName = Carbon::now()->year . '/giftcards/' . $card->id . '/' . time() . md5($image->getClientOriginalName()) . '.' . $image->getClientOriginalExtension();
            $path = public_path() . '/uploads/' . Carbon::now()->year . '/giftcards/' . $card->id;
            File::makeDirectory($path, $mode = 0777, true, true);
            $image->move($path, $imageName);
            $card->image = $imageName;
        }

        $card->update();
        $card->refresh();
        if (isset($request->cardprices)) {
            foreach ($request->cardprices as $cardprice) {

                    $cardpric = new CardPrices();
                    $cardpric->card_id = $card->id;
                    $cardpric->amount = $cardprice['amount'];
                    $cardpric->save();
                }
        }
        if ($request->is_preview == 1) {
            $url = '/admin/preview_card/' . $card->id;
        } else {
            $resourcesPath = $form->resource(0);
            $url = request(Builder::PREVIOUS_URL_KEY) ?: $resourcesPath;
        }
        return Redirect::to($url);
    }
    protected function form()
    {
        $form = new Form(new GiftCards);
        $form->tab('Card Information', function ($form) {
            /** @var Form $form */
            $form->setView('admin.card.card');
            $form->display('id', 'ID');
            $form->text('name_en', 'Title En')->required();

            $form->textarea('body_en', 'Body En')->required();;
            $form->text('name_ar', 'Title Ar')->required();;
            $form->textarea('body_ar', 'Body Ar')->required();
            $form->color('color', 'Color')->required();;
            $form->hidden('price')->default(0);
            $form->text('card_number', 'Card number');
            $form->image('image', 'Image')->move(Carbon::now()->year . '/giftcards')->uniqueName()->required();;
            $states = [
                'on' => ['value' => 0, 'text' => 'disabled', 'color' => 'danger'],
                'off' => ['value' => 1, 'text' => 'enabled', 'color' => 'success'],

            ];
            //        $form->status()->switch($statesss);

            $form->switch('status', 'Active')->states($states);
            $form->number('availability', 'Availability')->required();;

            $form->display('created_at', 'Created At');
            $form->display('updated_at', 'Updated At');
        })->tab('Card Prices', function ($form) {
            $form->hasMany('cardprices', 'Card Prices', function (Form\NestedForm $form) {
                $form->text('amount', 'Amount');
            });
        });
        $form->saving(function (Form $form) { {

                $form->card_number = $form->card_number . substr(bcrypt('132465'), 0, 6);
            }
        });

        $form->saved(function ($form) {
            if (request('image')) {
                $oldPath = $form->model()->image;
                $newPath = Carbon::now()->year . '/giftcards/' . $form->model()->id . '/' . $this->afterString(Carbon::now()->year . '/giftcards/', $form->model()->image);

                $form->model()->image = $newPath;
                $form->model()->save();

                $this->moveFile($oldPath, $newPath);
            }
            $url =  '/preview_card/' . $form->model()->id;
            //            return redirect(route('viewCard', $form->model()->id));
            //            return false;
        });

        return $form;
    }

    public function previewCard(Request $request, Content $content)
    {

        return \Encore\Admin\Facades\Admin::content(function (Content $content) {
            $card = PreviewGiftCards::find(request()->id);
            // optional
            $content->header('Gift Card');

            // optional
            $content->description('View Gift Card');

            // add breadcrumb since v1.5.7
            $content->breadcrumb(
                ['text' => 'Dashboard', 'url' => '/admin'],
                ['text' => 'Card management', 'url' => '/giftcards'],
                ['text' => 'Card ' . $card->name_en]
            );


            $content->row(view('admin.card')->with('card', $card));

            // method `row` is alias for `body`

        });
    }
    public function confirmCard(Request $request)
    {
        $card = GiftCards::find(request()->id);
        $card->status =  1;
        if ($card->update()) {
                return 'true';
            }
        return 'fasle';
    }
    public function approvecard(Request $request)
    {
        dd($request);
    }
}
