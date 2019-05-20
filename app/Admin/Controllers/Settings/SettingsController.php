<?php

namespace App\Admin\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Settings;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\Models\Currency;

class SettingsController extends Controller
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
		$grid = new Grid(new Settings);

		$grid->actions(function ($actions) use ($grid) {
			$actions->disableView();
		});

		$grid->id('ID')->sortable();
		$grid->created_at('Created at');
		$grid->updated_at('Updated at');
		$grid->actions(function ($actions) {
			$actions->disableDelete();
			//            $actions->disableCreation();
		});
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
		$show = new Show(Settings::findOrFail($id));

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
		$form = new Form(new Settings);
		$form->tab('General', function ($form) {
			$form->image('logo_ar');
			$form->image('logo_en');
			$form->text('copy_right_ar');
			$form->text('copy_right_en');
			$form->text('address_ar');
			$form->text('address_en');
			$form->mobile('phone');
			$form->text('google_map');
			$form->email('email_support');
			$form->email('email_info');
			$form->select('default_currency')
				->options(Currency::where('status', 1)->get(['name_en', 'id'])->pluck('name_en', 'id')->toArray());
			$form->text('working_hours');
			$form->number('new_arrival_days');
			$form->number('free_delivery_amount');
		})->tab('Social Media', function ($form) {
			$form->url('facebook');
			$form->url('twitter');
			$form->url('instagram');
			$form->text('whatsapp');
			$form->url('google_store_link');
			$form->url('app_store_link');
		})->tab('Banners', function ($form) {
			$form->image('banner_home');
			$form->image('banner_product_listing');
			$form->image('banner_product_details');
			$form->image('banner_categories_listing');
			$form->image('banner_characters_listing');
			$form->image('banner_cart');
			$form->image('banner_checkout');
			$form->image('banner_user_account');
			$form->image('banner_editaddresss');
			$form->image('banner_address_list');
			$form->image('banner_notification_setting');
			$form->image('banner_order_details');
			$form->image('banner_order_history');
			$form->image('banner_wishlist');
			$form->image('banner_login');
			$form->image('banner_career');
			$form->image('banner_faq');
			$form->image('banner_contactus');
			$form->image('banner_sitemap');
		})->tab('Google Ads', function ($form) {
			$form->textarea('google_ads_1');
			// $form->textarea('google_ads_2');
			// $form->textarea('google_ads_3');
		});

		return $form;
	}
}
