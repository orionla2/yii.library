<?php
/**
 * CGridView class file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

Yii::import('zii.widgets.CBaseListView');
//Yii::import('ext.customFilter.WidgetDataColumn');
//Yii::import('ext.customFilter.WidgetLinkColumn');
//Yii::import('ext.customFilter.WidgetButtonColumn');
//Yii::import('ext.customFilter.WidgetCheckBoxColumn');

/**
 * CGridView displays a list of data items in terms of a table.
 *
 * Each row of the table represents the data of a single data item, and a column usually represents
 * an attribute of the item (some columns may correspond to complex expression of attributes or static text).
 *
 * CGridView supports both sorting and pagination of the data items. The sorting
 * and pagination can be done in AJAX mode or normal page request. A benefit of using CGridView is that
 * when the user browser disables JavaScript, the sorting and pagination automatically degenerate
 * to normal page requests and are still functioning as expected.
 *
 * CGridView should be used together with a {@link IDataProvider data provider}, preferably a
 * {@link CActiveDataProvider}.
 *
 * The minimal code needed to use CGridView is as follows:
 *
 * <pre>
 * $dataProvider=new CActiveDataProvider('Post');
 *
 * $this->widget('zii.widgets.grid.CGridView', array(
 *     'dataProvider'=>$dataProvider,
 * ));
 * </pre>
 *
 * The above code first creates a data provider for the <code>Post</code> ActiveRecord class.
 * It then uses CGridView to display every attribute in every <code>Post</code> instance.
 * The displayed table is equiped with sorting and pagination functionality.
 *
 * In order to selectively display attributes with different formats, we may configure the
 * {@link CGridView::columns} property. For example, we may specify only the <code>title</code>
 * and <code>create_time</code> attributes to be displayed, and the <code>create_time</code>
 * should be properly formatted to show as a time. We may also display the attributes of the related
 * objects using the dot-syntax as shown below:
 *
 * <pre>
 * $this->widget('zii.widgets.grid.CGridView', array(
 *     'dataProvider'=>$dataProvider,
 *     'columns'=>array(
 *         'title',          // display the 'title' attribute
 *         'category.name',  // display the 'name' attribute of the 'category' relation
 *         'content:html',   // display the 'content' attribute as purified HTML
 *         array(            // display 'create_time' using an expression
 *             'name'=>'create_time',
 *             'value'=>'date("M j, Y", $data->create_time)',
 *         ),
 *         array(            // display 'author.username' using an expression
 *             'name'=>'authorName',
 *             'value'=>'$data->author->username',
 *         ),
 *         array(            // display a column with "view", "update" and "delete" buttons
 *             'class'=>'CButtonColumn',
 *         ),
 *     ),
 * ));
 * </pre>
 *
 * Please refer to {@link columns} for more details about how to configure this property.
 *
 * @property boolean $hasFooter Whether the table should render a footer.
 * This is true if any of the {@link columns} has a true {@link WidgetGridColumn::hasFooter} value.
 * @property CFormatter $formatter The formatter instance. Defaults to the 'format' application component.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @package zii.widgets.grid
 * @since 1.1
 */
class WidgetGridView extends CBaseListView
{
	const FILTER_POS_HEADER='header';
	const FILTER_POS_FOOTER='footer';
	const FILTER_POS_BODY='body';
    public $menu;
    public $controller;
    public $itemsTagName;
    public $itemView;
    public $textLength;
    private $_formatter;
	/**
	 * @var array grid column configuration. Each array element represents the configuration
	 * for one particular grid column which can be either a string or an array.
	 *
	 * When a column is specified as a string, it should be in the format of "name:type:header",
	 * where "type" and "header" are optional. A {@link CDataColumn} instance will be created in this case,
	 * whose {@link CDataColumn::name}, {@link CDataColumn::type} and {@link CDataColumn::header}
	 * properties will be initialized accordingly.
	 *
	 * When a column is specified as an array, it will be used to create a grid column instance, where
	 * the 'class' element specifies the column class name (defaults to {@link CDataColumn} if absent).
	 * Currently, these official column classes are provided: {@link CDataColumn},
	 * {@link CLinkColumn}, {@link CButtonColumn} and {@link CCheckBoxColumn}.
	 */
	public $columns=array();
	/**
	 * @var array the CSS class names for the table body rows. If multiple CSS class names are given,
	 * they will be assigned to the rows sequentially and repeatedly. This property is ignored
	 * if {@link rowCssClassExpression} is set. Defaults to <code>array('odd', 'even')</code>.
	 * @see rowCssClassExpression
	 */
	public $rowCssClass=array('odd','even');
	/**
	 * @var string a PHP expression that is evaluated for every table body row and whose result
	 * is used as the CSS class name for the row. In this expression, you can use the following variables:
	 * <ul>
	 *   <li><code>$row</code> the row number (zero-based)</li>
	 *   <li><code>$data</code> the data model for the row</li>
	 *   <li><code>$this</code> the grid view object</li>
	 * </ul>
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 * @see rowCssClass
	 * @deprecated in 1.1.13 in favor of {@link rowHtmlOptionsExpression}
	 */
	public $rowCssClassExpression;
	/**
	 * @var string a PHP expression that is evaluated for every table body row and whose result
	 * is used as additional HTML attributes for the row. The expression should return an
	 * array whose key value pairs correspond to html attribute and value.
	 * In this expression, you can use the following variables:
	 * <ul>
	 *   <li><code>$row</code> the row number (zero-based)</li>
	 *   <li><code>$data</code> the data model for the row</li>
	 *   <li><code>$this</code> the grid view object</li>
	 * </ul>
	 * The PHP expression will be evaluated using {@link evaluateExpression}.
	 *
	 * A PHP expression can be any PHP code that has a value. To learn more about what an expression is,
	 * please refer to the {@link http://www.php.net/manual/en/language.expressions.php php manual}.
	 * @since 1.1.13
	 */
	public $rowHtmlOptionsExpression;
	/**
	 * @var boolean whether to display the table even when there is no data. Defaults to true.
	 * The {@link emptyText} will be displayed to indicate there is no data.
	 */
	public $showTableOnEmpty=true;
	/**
	 * @var mixed the ID of the container whose content may be updated with an AJAX response.
	 * Defaults to null, meaning the container for this grid view instance.
	 * If it is set false, it means sorting and pagination will be performed in normal page requests
	 * instead of AJAX requests. If the sorting and pagination should trigger the update of multiple
	 * containers' content in AJAX fashion, these container IDs may be listed here (separated with comma).
	 */
	public $ajaxUpdate;
	/**
	 * @var string the jQuery selector of the HTML elements that may trigger AJAX updates when they are clicked.
	 * These tokens are recognized: {page} and {sort}. They will be replaced with the pagination and sorting links selectors.
	 * Defaults to '{page}, {sort}', that means that the pagination links and the sorting links will trigger AJAX updates.
	 * Tokens are available from 1.1.11
	 *
	 * Note: if this value is empty an exception will be thrown.
	 *
	 * Example (adding a custom selector to the default ones):
	 * <pre>
	 *  ...
	 *  'updateSelector'=>'{page}, {sort}, #mybutton',
	 *  ...
	 * </pre>
	 * @since 1.1.7
	 */
	public $updateSelector='{page}, {sort}';
	/**
	 * @var string a javascript function that will be invoked if an AJAX update error occurs.
	 *
	 * The function signature is <code>function(xhr, textStatus, errorThrown, errorMessage)</code>
	 * <ul>
	 * <li><code>xhr</code> is the XMLHttpRequest object.</li>
	 * <li><code>textStatus</code> is a string describing the type of error that occurred.
	 * Possible values (besides null) are "timeout", "error", "notmodified" and "parsererror"</li>
	 * <li><code>errorThrown</code> is an optional exception object, if one occurred.</li>
	 * <li><code>errorMessage</code> is the CGridView default error message derived from xhr and errorThrown.
	 * Useful if you just want to display this error differently. CGridView by default displays this error with an javascript.alert()</li>
	 * </ul>
	 * Note: This handler is not called for JSONP requests, because they do not use an XMLHttpRequest.
	 *
	 * Example (add in a call to CGridView):
	 * <pre>
	 *  ...
	 *  'ajaxUpdateError'=>'function(xhr,ts,et,err,id){ $("#"+id).text(err); }',
	 *  ...
	 * </pre>
	 */
	public $ajaxUpdateError;
	/**
	 * @var string the name of the GET variable that indicates the request is an AJAX request triggered
	 * by this widget. Defaults to 'ajax'. This is effective only when {@link ajaxUpdate} is not false.
	 */
	public $ajaxVar='ajax';
	/**
	 * @var mixed the URL for the AJAX requests should be sent to. {@link CHtml::normalizeUrl()} will be
	 * called on this property. If not set, the current page URL will be used for AJAX requests.
	 * @since 1.1.8
	 */
	public $ajaxUrl;
	/**
	 * @var string the type ('GET' or 'POST') of the AJAX requests. If not set, 'GET' will be used.
	 * You can set this to 'POST' if you are filtering by many fields at once and have a problem with GET query string length.
	 * Note that in POST mode direct links and {@link enableHistory} feature may not work correctly!
	 * @since 1.1.14
	 */
	public $ajaxType;
	/**
	 * @var string a javascript function that will be invoked before an AJAX update occurs.
	 * The function signature is <code>function(id,options)</code> where 'id' refers to the ID of the grid view,
	 * 'options' the AJAX request options  (see jQuery.ajax api manual).
	 */
	public $beforeAjaxUpdate;
	/**
	 * @var string a javascript function that will be invoked after a successful AJAX response is received.
	 * The function signature is <code>function(id, data)</code> where 'id' refers to the ID of the grid view,
	 * 'data' the received ajax response data.
	 */
	public $afterAjaxUpdate;
	/**
	 * @var string a javascript function that will be invoked after the row selection is changed.
	 * The function signature is <code>function(id)</code> where 'id' refers to the ID of the grid view.
	 * In this function, you may use <code>$(gridID).yiiGridView('getSelection')</code> to get the key values
	 * of the currently selected rows (gridID is the DOM selector of the grid).
	 * @see selectableRows
	 */
	public $selectionChanged;
	/**
	 * @var integer the number of table body rows that can be selected. If 0, it means rows cannot be selected.
	 * If 1, only one row can be selected. If 2 or any other number, it means multiple rows can be selected.
	 * A selected row will have a CSS class named 'selected'. You may also call the JavaScript function
	 * <code>$(gridID).yiiGridView('getSelection')</code> to retrieve the key values of the currently selected
	 * rows (gridID is the DOM selector of the grid).
	 */
	public $selectableRows=1;
	/**
	 * @var string the base script URL for all grid view resources (eg javascript, CSS file, images).
	 * Defaults to null, meaning using the integrated grid view resources (which are published as assets).
	 */
	public $baseScriptUrl;
	/**
	 * @var string the URL of the CSS file used by this grid view. Defaults to null, meaning using the integrated
	 * CSS file. If this is set false, you are responsible to explicitly include the necessary CSS file in your page.
	 */
	public $cssFile;
	/**
	 * @var string the text to be displayed in a data cell when a data value is null. This property will NOT be HTML-encoded
	 * when rendering. Defaults to an HTML blank.
	 */
	public $nullDisplay='&nbsp;';
	/**
	 * @var string the text to be displayed in an empty grid cell. This property will NOT be HTML-encoded when rendering. Defaults to an HTML blank.
	 * This differs from {@link nullDisplay} in that {@link nullDisplay} is only used by {@link CDataColumn} to render
	 * null data values.
	 * @since 1.1.7
	 */
	public $blankDisplay='&nbsp;';
	/**
	 * @var string the CSS class name that will be assigned to the widget container element
	 * when the widget is updating its content via AJAX. Defaults to 'grid-view-loading'.
	 * @since 1.1.1
	 */
	public $loadingCssClass='grid-view-loading';
	/**
	 * @var string the jQuery selector of filter input fields.
	 * The token '{filter}' is recognized and it will be replaced with the grid filters selector.
	 * Defaults to '{filter}'.
	 *
	 * Note: if this value is empty an exception will be thrown.
	 *
	 * Example (adding a custom selector to the default one):
	 * <pre>
	 *  ...
	 *  'filterSelector'=>'{filter}, #myfilter',
	 *  ...
	 * </pre>
	 * @since 1.1.13
	 */
	public $filterSelector='{filter}';
	/**
	 * @var string the CSS class name for the table row element containing all filter input fields. Defaults to 'filters'.
	 * @see filter
	 * @since 1.1.1
	 */
	public $filterCssClass='filters';
	/**
	 * @var string whether the filters should be displayed in the grid view. Valid values include:
	 * <ul>
	 *    <li>header: the filters will be displayed on top of each column's header cell.</li>
	 *    <li>body: the filters will be displayed right below each column's header cell.</li>
	 *    <li>footer: the filters will be displayed below each column's footer cell.</li>
	 * </ul>
	 * @see filter
	 * @since 1.1.1
	 */
	public $filterPosition='body';
	/**
	 * @var CModel the model instance that keeps the user-entered filter data. When this property is set,
	 * the grid view will enable column-based filtering. Each data column by default will display a text field
	 * at the top that users can fill in to filter the data.
	 * Note that in order to show an input field for filtering, a column must have its {@link CDataColumn::name}
	 * property set or have {@link CDataColumn::filter} as the HTML code for the input field.
	 * When this property is not set (null) the filtering is disabled.
	 * @since 1.1.1
	 */
	public $filter;
	/**
	 * @var boolean whether to hide the header cells of the grid. When this is true, header cells
	 * will not be rendered, which means the grid cannot be sorted anymore since the sort links are located
	 * in the header. Defaults to false.
	 * @since 1.1.1
	 */
	public $hideHeader=false;
	/**
	 * @var boolean whether to leverage the {@link https://developer.mozilla.org/en/DOM/window.history DOM history object}.  Set this property to true
	 * to persist state of grid across page revisits.  Note, there are two limitations for this feature:
	 * <ul>
	 *    <li>this feature is only compatible with browsers that support HTML5.</li>
	 *    <li>expect unexpected functionality (e.g. multiple ajax calls) if there is more than one grid/list on a single page with enableHistory turned on.</li>
	 * </ul>
	 * @since 1.1.11
	 */
	public $enableHistory=false;


	/**
	 * Initializes the grid view.
	 * This method will initialize required property values and instantiate {@link columns} objects.
	 */
	public function init()
	{
		parent::init();

		if(empty($this->updateSelector))
			throw new CException(Yii::t('zii','The property updateSelector should be defined.'));
		if(empty($this->filterSelector))
			throw new CException(Yii::t('zii','The property filterSelector should be defined.'));

		if(!isset($this->htmlOptions['class']))
			$this->htmlOptions['class']='grid-view';

		if($this->baseScriptUrl===null)
			//$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('zii.widgets.assets')).'/gridview';
			$this->baseScriptUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('ext.customFilter.gridview'));

		if($this->cssFile!==false)
		{
			if($this->cssFile===null)
				$this->cssFile=$this->baseScriptUrl.'/styles.css';
			Yii::app()->getClientScript()->registerCssFile($this->cssFile);
		}

		$this->initColumns();
	}

	/**
	 * Creates column objects and initializes them.
	 */
	protected function initColumns(){
	}

	/**
	 * Creates a {@link CDataColumn} based on a shortcut column specification string.
	 * @param string $text the column specification string
	 * @return CDataColumn the column instance
	 */
	protected function createDataColumn($text){
	}

	/**
	 * Registers necessary client scripts.
	 */
	public function registerClientScript(){
		$id=$this->getId();

		if($this->ajaxUpdate===false)
			$ajaxUpdate=false;
		else
			$ajaxUpdate=array_unique(preg_split('/\s*,\s*/',$this->ajaxUpdate.','.$id,-1,PREG_SPLIT_NO_EMPTY));
		$options=array(
			'ajaxUpdate'=>$ajaxUpdate,
			'ajaxVar'=>$this->ajaxVar,
			'pagerClass'=>$this->pagerCssClass,
			'loadingClass'=>$this->loadingCssClass,
			'filterClass'=>$this->filterCssClass,
			'tableClass'=>$this->itemsCssClass,
			'selectableRows'=>$this->selectableRows,
			'enableHistory'=>$this->enableHistory,
			'updateSelector'=>$this->updateSelector,
			'filterSelector'=>$this->filterSelector
		);
		if($this->ajaxUrl!==null)
			$options['url']=CHtml::normalizeUrl($this->ajaxUrl);
		if($this->ajaxType!==null) {
			$options['ajaxType']=strtoupper($this->ajaxType);
			$request=Yii::app()->getRequest();
			if ($options['ajaxType']=='POST' && $request->enableCsrfValidation) {
				$options['csrfTokenName']=$request->csrfTokenName;
				$options['csrfToken']=$request->getCsrfToken();
			}
		}
		if($this->enablePagination)
			$options['pageVar']=$this->dataProvider->getPagination()->pageVar;
		foreach(array('beforeAjaxUpdate', 'afterAjaxUpdate', 'ajaxUpdateError', 'selectionChanged') as $event)
		{
			if($this->$event!==null)
			{
				if($this->$event instanceof CJavaScriptExpression)
					$options[$event]=$this->$event;
				else
					$options[$event]=new CJavaScriptExpression($this->$event);
			}
		}

		$options=CJavaScript::encode($options);
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		$cs->registerCoreScript('bbq');
		if($this->enableHistory)
			$cs->registerCoreScript('history');
		$cs->registerScriptFile($this->baseScriptUrl.'/jquery.yiigridview.js',CClientScript::POS_END);
		$cs->registerScript(__CLASS__.'#'.$id,"jQuery('#$id').yiiGridView($options);");
	}
    
    public function stringsToArray ($string) {
        $retArr = explode(',',$string);
        return $retArr;
    }
    public function shortDescription ($string) {
        $text =  strip_tags(preg_replace("/\s{2,}/"," ",$string));
        if (!empty($this->textLength)) {
            $cut = $this->textLength;
        } else {
            $cut = strlen($text);
        }
        $str = mb_substr($text,0,$cut);
        return $str;
    }
    public function clearText($string) {
        $string = str_replace('&nbsp;',' ',$string);
        $string = str_replace('&rsquo;',"'",$string);
        $string = str_replace('&quot;','"',$string);
        $string = str_replace('&#39;',"'",$string);
        $string = trim($string);
        return $string;
    }
	/**
	 * Renders the data items for the grid view.
	 */
	public function renderItems()
	{
		echo CHtml::openTag($this->itemsTagName,array('class'=>$this->itemsCssClass))."\n";
		$data=$this->dataProvider->getData();
		if(($n=count($data))>0)
		{
			$owner=$this->getOwner();
			$viewFile=$owner->getViewFile($this->itemView);
			$j=0;
            echo '<table><tr><td>';
			foreach($data as $i=>$item)
			{
                $item->picture = $this->stringsToArray($item->picture);
                $item->description = $this->shortDescription($this->clearText($item->description));
                $item->price = Money::getPrice($item->price);
                $data = array();
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
				$owner->renderFile($viewFile,$data);
                
				if($j++ == 1){
					echo '<div class="cleaner_with_height">&nbsp</div></td></tr><tr><td>';
                    $j=0;
                } else {
                    echo '<div class="cleaner_with_width">&nbsp</div></td><td>';
                }
			}
            echo '</tr></table>';
		}
		else
			$this->renderEmptyText();
		echo CHtml::closeTag($this->itemsTagName);
	}
	/**
	 * A seam for people extending CGridView to be able to hook onto the data cell rendering process.
	 * 
	 * By overriding only this method we will not need to copypaste and modify the whole entirety of `renderTableRow`.
	 * Or override `renderDataCell()` method of all possible WidgetGridColumn descendants.
	 * 
	 * @param WidgetGridColumn $column The Column instance to 
	 * @param integer $row
	 * @since 1.1.17
	 */
	protected function renderDataWidget($column, $row)
	{
        return $column->renderDataWidget($row);
	}
	
	/**
	 * @return boolean whether the table should render a footer.
	 * This is true if any of the {@link columns} has a true {@link WidgetGridColumn::hasFooter} value.
	 */
	public function getHasFooter()
	{
		foreach($this->columns as $column)
			if($column->getHasFooter())
				return true;
		return false;
	}

	/**
	 * @return CFormatter the formatter instance. Defaults to the 'format' application component.
	 */
	public function getFormatter()
	{
		if($this->_formatter===null)
			$this->_formatter=Yii::app()->format;
		return $this->_formatter;
	}

	/**
	 * @param CFormatter $value the formatter instance
	 */
	public function setFormatter($value)
	{
		$this->_formatter=$value;
	}
}
