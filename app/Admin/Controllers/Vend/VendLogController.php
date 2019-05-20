<?php

namespace App\Admin\Controllers\Vend;

use App\Http\Classes\Vend;
use App\Models\VendLog;
use App\Http\Controllers\Controller;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class VendLogController extends Controller {

	/**
	 * Index interface.
	 *
	 * @param Content $content
	 *
	 * @return Content
	 */
	public function index( Content $content ) {
		return $content
			->header( 'Vend' )
			->description( 'Log' )
			->body( $this->grid() );
	}

	/**
	 * Show interface.
	 *
	 * @param mixed $id
	 * @param Content $content
	 *
	 * @return Content
	 */
	public function show( $id, Content $content ) {
		return $content
			->header( 'Vend' )
			->description( 'Log' )
			->body( $this->detail( $id ) );
	}

	/**
	 * Make a grid builder.
	 *
	 * @return Grid
	 */
	protected function grid() {
		$grid = new Grid( new VendLog );

		$grid->tools->disableBatchActions();
		$grid->disableCreateButton();

		$grid->actions( function ( $actions ) {
			$actions->disableDelete();
			$actions->disableEdit();
		} );
		$grid->filter( function ( \Encore\Admin\Grid\Filter $filter ) {
			$filter->disableIdFilter();

			$filter->in( 'type', 'Type' )->select([
				Vend::API_URL_BRAND,
				Vend::API_URL_REFRESH_TOKEN,
				Vend::API_URL_SUPPLIERS,
				Vend::API_URL_PRODUCTS,
				Vend::API_URL_INVENTORY,
				Vend::API_URL_REG_SALES,
				Vend::API_URL_PAYMENT_TYPES,
			]);

			$filter->between('created_at', 'Date Range')->date();

		} );

		$grid->id( 'Id' );
		$grid->type( 'Type' );
//		$grid->note( 'Note' );
		$grid->error( 'Error' );
		$grid->created_at( 'Date' );
//		$grid->updated_at( 'Updated at' );

		return $grid;
	}

	/**
	 * Make a show builder.
	 *
	 * @param mixed $id
	 *
	 * @return Show
	 */
	protected function detail( $id ) {
		$show = new Show( VendLog::findOrFail( $id ) );
		$show->panel()
		     ->tools( function ( $tools ) {
			     $tools->disableEdit();
			     $tools->disableDelete();
		     } );

		$show->id( 'Id' );
		$show->type( 'Type' );
		$show->note( 'Note' );
		$show->error( 'Error' );
		$show->created_at( 'Date' );
//		$show->updated_at( 'Updated at' );

		return $show;
	}

}
