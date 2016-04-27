<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i> <?php echo $button_cancel; ?></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?> : <?php echo $order_no; ?></h3>
      </div>
      <div class="panel-body">

        <!--隐藏表单，异步登录api/login验证-->
        <select name="store" id="input-store" class="form-control hidden">
          <?php foreach ($stores as $store) { ?>
          <?php if ($store['store_id'] == $store_id) { ?>
          <option value="<?php echo $store['href']; ?>" selected="selected"><?php echo $store['name']; ?></option>
          <?php } else { ?>
          <option value="<?php echo $store['href']; ?>"><?php echo $store['name']; ?></option>
          <?php } ?>
          <?php } ?>
        </select>

        <div class="container-fluid">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-info-circle"></i> 订单详情</h3>
            </div>
            <div class="panel-body">
              <table class="table table-bordered">
                <thead>
                <tr>
                  <td style="width: 50%;" class="text-left">订单基础信息</td>
                  <?php if ($order_exhibition) { ?>
                  <td style="width: 50%;" class="text-left">展台资料
                    <?php } ?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td class="text-left"><?php echo $order_info_base; ?></td>
                  <?php if ($order_exhibition) { ?>
                  <td class="text-left"><?php echo $order_exhibition; ?></td>
                  <?php } ?>
                </tr>
                </tbody>
              </table>
              <table class="table table-bordered">
                <thead>
                <tr>
                  <td class="text-left"><?php echo $column_product; ?></td>
                  <td class="text-left"><?php echo $column_model; ?></td>
                  <td class="text-left">设计师</td>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $product) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a>
                    <?php foreach ($product['option'] as $option) { ?>
                    <br />
                    <?php if ($option['type'] != 'file') { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                    <?php } else { ?>
                    &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
                    <?php } ?>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $product['model']; ?></td>
                  <td class="text-left"><?php echo $product['designer_name']; ?></td>
                </tr>
                <?php } ?>
                <?php foreach ($vouchers as $voucher) { ?>
                <tr>
                  <td class="text-left"><a href="<?php echo $voucher['href']; ?>"><?php echo $voucher['description']; ?></a></td>
                  <td class="text-left"></td>
                  <td class="text-right">1</td>
                  <td class="text-right"><?php echo $voucher['amount']; ?></td>
                  <td class="text-right"><?php echo $voucher['amount']; ?></td>
                </tr>
                <?php } ?>
                <?php foreach ($totals as $total) { ?>
                <tr>
                  <td colspan="4" class="text-right"><?php echo $total['title']; ?></td>
                  <td class="text-right"><?php echo $total['text']; ?></td>
                </tr>
                <?php } ?>
                </tbody>
              </table>
              <?php if ($comment) { ?>
              <table class="table table-bordered">
                <thead>
                <tr>
                  <td><?php echo $text_comment; ?></td>
                </tr>
                </thead>
                <tbody>
                <tr>
                  <td><?php echo $comment; ?></td>
                </tr>
                </tbody>
              </table>
              <?php } ?>
            </div>
          </div>
        </div>


        <form class="form-horizontal" onsubmit="return false;">
          <ul id="order" class="nav nav-tabs nav-justified">
            <!--<li class="disabled active"><a href="#tab-customer" data-toggle="tab">1. <?php echo $tab_customer; ?></a></li>
            <li class="disabled"><a href="#tab-cart" data-toggle="tab">2. <?php echo $tab_product; ?></a></li>
            <li class="disabled"><a href="#tab-payment" data-toggle="tab">3. <?php echo $tab_payment; ?></a></li>
            <li class="disabled"><a href="#tab-shipping" data-toggle="tab">4. <?php echo $tab_shipping; ?></a></li>
            <li class="disabled"><a href="#tab-total" data-toggle="tab">5. <?php echo $tab_total; ?></a></li>-->

            <li class="active"><a href="#tab-design" data-toggle="tab">设计方案</a></li>
            <li class=""><a href="#tab-payment" data-toggle="tab">确认费用</a></li>
            <li class=""><a href="#tab-processing" data-toggle="tab">工程进度</a></li>
            <li class=""><a href="#tab-modify" data-toggle="tab">修改状态</a></li>
          </ul>
          <div class="tab-content">
            <!--设计方案内容开始-->
            <div class="tab-pane active" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <td class="text-left">设计标题</td>
                    <td class="text-left">设计描述</td>
                    <td class="text-right">日期</td>
                    <td class="text-right">操作</td>
                  </tr>
                  </thead>
                  <tbody id="design">
                  <?php if ($order_designs) { ?>
                  <?php foreach($order_designs as $order_design) { ?>
                  <tr>
                    <td class="text-left"><?php echo $order_design['title']; ?></td>
                    <td class="text-left"><?php echo $order_design['description']; ?></td>
                    <td class="text-right"><?php echo $order_design['date_added']; ?></td>
                    <td class="text-right"><a href="<?php echo $order_design['edit']; ?>" data-toggle="tooltip" title="编辑该方案" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                  </tr>
                  <?php } ?>
                  <?php } else {  ?>
                  <tr>
                    <td class="text-center" colspan="4"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td class="text-right" colspan="4">
                      <a href="<?php echo $order_design_add; ?>" data-toggle="tooltip" title="添加设计师方案" class="btn btn-success"><i class="fa fa-plus"></i></a>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>

            </div>
            <!--设计方案内容结束-->
            <div class="tab-pane" id="tab-ddd">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $column_product; ?></td>
                      <td class="text-left"><?php echo $column_model; ?></td>
                      <td class="text-right"><?php echo $column_quantity; ?></td>
                      <td class="text-right"><?php echo $column_price; ?></td>
                      <td class="text-right"><?php echo $column_total; ?></td>
                      <td><?php echo $column_action; ?></td>
                    </tr>
                  </thead>
                  <tbody id="cart">
                    <?php if ($order_products || $order_vouchers) { ?>
                    <?php $product_row = 0; ?>
                    <?php foreach ($order_products as $order_product) { ?>
                    <tr>
                      <td class="text-left"><?php echo $order_product['name']; ?><br />
                        <input type="hidden" name="product[<?php echo $product_row; ?>][product_id]" value="<?php echo $order_product['product_id']; ?>" />
                        <?php foreach ($order_product['option'] as $option) { ?>
                        - <small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small><br />
                        <?php if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'image') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['product_option_value_id']; ?>" />
                        <?php } ?>
                        <?php if ($option['type'] == 'checkbox') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option['product_option_value_id']; ?>" />
                        <?php } ?>
                        <?php if ($option['type'] == 'text' || $option['type'] == 'textarea' || $option['type'] == 'file' || $option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') { ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][option][<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" />
                        <?php } ?>
                        <?php } ?></td>
                      <td class="text-left"><?php echo $order_product['model']; ?></td>
                      <td class="text-right"><?php echo $order_product['quantity']; ?>
                        <input type="hidden" name="product[<?php echo $product_row; ?>][quantity]" value="<?php echo $order_product['quantity']; ?>" /></td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                      <td class="text-center"></td>
                    </tr>
                    <?php $product_row++; ?>
                    <?php } ?>
                    <?php $voucher_row = 0; ?>
                    <?php foreach ($order_vouchers as $order_voucher) { ?>
                    <tr>
                      <td class="text-left"><?php echo $order_voucher['description']; ?>
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][voucher_id]" value="<?php echo $order_voucher['voucher_id']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][description]" value="<?php echo $order_voucher['description']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][code]" value="<?php echo $order_voucher['code']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][from_name]" value="<?php echo $order_voucher['from_name']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][from_email]" value="<?php echo $order_voucher['from_email']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][to_name]" value="<?php echo $order_voucher['to_name']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][to_email]" value="<?php echo $order_voucher['to_email']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][voucher_theme_id]" value="<?php echo $order_voucher['voucher_theme_id']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][message]" value="<?php echo $order_voucher['message']; ?>" />
                        <input type="hidden" name="voucher[<?php echo $voucher_row; ?>][amount]" value="<?php echo $order_voucher['amount']; ?>" /></td>
                      <td class="text-left"></td>
                      <td class="text-right">1</td>
                      <td class="text-right"></td>
                      <td class="text-right"></td>
                      <td class="text-center"></td>
                    </tr>
                    <?php $voucher_row++; ?>
                    <?php } ?>
                    <?php } else { ?>
                    <tr>
                      <td class="text-center" colspan="6"><?php echo $text_no_results; ?></td>
                    </tr>
                  </tbody>
                  <?php } ?>
                </table>
              </div>
              <ul class="nav nav-tabs nav-justified hidden">
                <li class="active"><a href="#tab-product" data-toggle="tab"><?php echo $tab_product; ?></a></li>
                <li><a href="#tab-voucher" data-toggle="tab"><?php echo $tab_voucher; ?></a></li>
              </ul>
              <div class="tab-content hidden">
                <div class="tab-pane active" id="tab-product">
                  <fieldset>
                    <legend><?php echo $text_product; ?></legend>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-product"><?php echo $entry_product; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="product" value="" id="input-product" class="form-control" />
                        <input type="hidden" name="product_id" value="" />
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="quantity" value="1" id="input-quantity" class="form-control" />
                      </div>
                    </div>
                    <div id="option"></div>
                  </fieldset>
                  <div class="text-right">
                    <button type="button" id="button-product-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_product_add; ?></button>
                  </div>
                </div>
                <div class="tab-pane" id="tab-voucher">
                  <fieldset>
                    <legend><?php echo $text_voucher; ?></legend>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-to-name"><?php echo $entry_to_name; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="to_name" value="" id="input-to-name" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-to-email"><?php echo $entry_to_email; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="to_email" value="" id="input-to-email" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-from-name"><?php echo $entry_from_name; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="from_name" value="" id="input-from-name" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-from-email"><?php echo $entry_from_email; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="from_email" value="" id="input-from-email" class="form-control" />
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-theme"><?php echo $entry_theme; ?></label>
                      <div class="col-sm-10">
                        <select name="voucher_theme_id" id="input-theme" class="form-control">
                          <?php foreach ($voucher_themes as $voucher_theme) { ?>
                          <option value="<?php echo $voucher_theme['voucher_theme_id']; ?>"><?php echo $voucher_theme['name']; ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-sm-2 control-label" for="input-message"><?php echo $entry_message; ?></label>
                      <div class="col-sm-10">
                        <textarea name="message" rows="5" id="input-message" class="form-control"></textarea>
                      </div>
                    </div>
                    <div class="form-group required">
                      <label class="col-sm-2 control-label" for="input-amount"><?php echo $entry_amount; ?></label>
                      <div class="col-sm-10">
                        <input type="text" name="amount" value="<?php echo $voucher_min; ?>" id="input-amount" class="form-control" />
                      </div>
                    </div>
                  </fieldset>
                  <div class="text-right">
                    <button type="button" id="button-voucher-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?php echo $button_voucher_add; ?></button>
                  </div>
                </div>
              </div>
              <br />
              <div class="row">
                <div class="col-sm-6 text-left">
                  <button type="button" onclick="$('a[href=\'#tab-customer\']').tab('show');" class="btn btn-default"><i class="fa fa-arrow-left"></i> <?php echo $button_back; ?></button>
                </div>
                <div class="col-sm-6 text-right">
                  <button type="button" id="button-cart" class="btn btn-primary"><i class="fa fa-arrow-right"></i> <?php echo $button_continue; ?></button>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-payment">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="input-total">订单总价：</label>
                <div class="col-sm-10">
                  <input type="text" name="total" value="<?php echo $total; ?>" id="input-total" class="form-control" />
                </div>
              </div>
              <div class="row">
                <div class="col-sm-6 text-right">
                  <button type="button" id="button-total" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-arrow-right"></i> 修改总价</button>
                </div>
              </div>
            </div>

            <!--进度图内容开始-->
            <div class="tab-pane" id="tab-processing">
              <div class="table-responsive">
                <table class="table table-bordered">
                  <thead>
                  <tr>
                    <td class="text-left">标题</td>
                    <td class="text-right">日期</td>
                    <td class="text-right">操作</td>
                  </tr>
                  </thead>
                  <tbody id="design">
                  <?php if ($order_processing) { ?>
                  <?php foreach($order_processing as $processing) { ?>
                  <tr>
                    <td class="text-left"><?php echo $processing['title']; ?></td>
                    <td class="text-right"><?php echo $processing['date_added']; ?></td>
                    <td class="text-right"><a href="<?php echo $processing['edit']; ?>" data-toggle="tooltip" title="编辑进度项" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
                  </tr>
                  <?php } ?>
                  <?php } else {  ?>
                  <tr>
                    <td class="text-center" colspan="3"><?php echo $text_no_results; ?></td>
                  </tr>
                  <?php } ?>
                  <tr>
                    <td class="text-right" colspan="3">
                      <a href="<?php echo $order_processing_add; ?>" data-toggle="tooltip" title="添加进度项" class="btn btn-success"><i class="fa fa-plus"></i></a>
                    </td>
                  </tr>
                  </tbody>
                </table>
              </div>
            </div>
            <!--进度图结束-->
            <div class="tab-pane" id="tab-modify">


              <div class="panel-body">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-history" data-toggle="tab">历史</a></li>
                  <li><a href="#tab-additional" data-toggle="tab">其他</a></li>
                  <?php foreach ($tabs as $tab) { ?>
                  <li><a href="#tab-<?php echo $tab['code']; ?>" data-toggle="tab"><?php echo $tab['title']; ?></a></li>
                  <?php } ?>
                </ul>
                <div class="tab-content">
                  <div class="tab-pane active" id="tab-history">
                    <div id="history"></div>
                    <br />
                    <fieldset>
                      <legend>添加订单记录</legend>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-order-status">订单状态：</label>
                          <div class="col-sm-10">
                            <select name="order_status_id" id="input-order-status" class="form-control">
                              <?php foreach ($order_statuses as $order_statuses) { ?>
                              <?php if ($order_statuses['order_status_id'] == $order_status_id) { ?>
                              <option value="<?php echo $order_statuses['order_status_id']; ?>" selected="selected"><?php echo $order_statuses['name']; ?></option>
                              <?php } else { ?>
                              <option value="<?php echo $order_statuses['order_status_id']; ?>"><?php echo $order_statuses['name']; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                        <div class="form-group hidden">
                          <label class="col-sm-2 control-label" for="input-override">覆盖：</label>
                          <div class="col-sm-10">
                            <input type="checkbox" name="override" value="1" id="input-override" checked />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-notify">通知客户：</label>
                          <div class="col-sm-10">
                            <input type="checkbox" name="notify" value="1" id="input-notify" />
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-sm-2 control-label" for="input-comment">订单附言：</label>
                          <div class="col-sm-10">
                            <textarea name="comment" rows="8" id="input-comment" class="form-control"></textarea>
                          </div>
                        </div>
                    </fieldset>
                    <div class="text-right">
                      <button id="button-history" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i> 添加订单记录</button>
                    </div>
                  </div>
                  <div class="tab-pane" id="tab-additional">
                    <?php if ($account_custom_fields) { ?>
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                        <td colspan="2"><?php echo $text_account_custom_field; ?></td>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($account_custom_fields as $custom_field) { ?>
                      <tr>
                        <td><?php echo $custom_field['name']; ?></td>
                        <td><?php echo $custom_field['value']; ?></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                    <?php } ?>
                    <?php if ($payment_custom_fields) { ?>
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                        <td colspan="2"><?php echo $text_payment_custom_field; ?></td>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($payment_custom_fields as $custom_field) { ?>
                      <tr>
                        <td><?php echo $custom_field['name']; ?></td>
                        <td><?php echo $custom_field['value']; ?></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                    <?php } ?>
                    <?php if ($shipping_method && $shipping_custom_fields) { ?>
                    <table class="table table-bordered">
                      <thead>
                      <tr>
                        <td colspan="2"><?php echo $text_shipping_custom_field; ?></td>
                      </tr>
                      </thead>
                      <tbody>
                      <?php foreach ($shipping_custom_fields as $custom_field) { ?>
                      <tr>
                        <td><?php echo $custom_field['name']; ?></td>
                        <td><?php echo $custom_field['value']; ?></td>
                      </tr>
                      <?php } ?>
                      </tbody>
                    </table>
                    <?php } ?>
                  </div>
                  <?php foreach ($tabs as $tab) { ?>
                  <div class="tab-pane" id="tab-<?php echo $tab['code']; ?>"><?php echo $tab['content']; ?></div>
                  <?php } ?>
                </div>
              </div>


              <div class="row">
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
// Disable the tabs
//$('#order a[data-toggle=\'tab\']').on('click', function(e) {
//	return false;
//});

var token = '';

// Login to the API
$.ajax({
  url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/login',
	type: 'post',
	data: 'key=<?php echo $api_key; ?>',
	dataType: 'json',
	crossDomain: true,
	success: function(json) {
        $('.alert').remove();

        if (json['error']) {
    		if (json['error']['key']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['key'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    		}

            if (json['error']['ip']) {
    			$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['ip'] + ' <button type="button" id="button-ip-add" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger btn-xs pull-right"><i class="fa fa-plus"></i> <?php echo $button_ip_add; ?></button></div>');
    		}
        }

		if (json['token']) {
			token = json['token'];

            $('select[name=\'currency\']').trigger('change');
		}
	},
	error: function(xhr, ajaxOptions, thrownError) {
		alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	}
});

$(document).delegate('#button-ip-add', 'click', function() {
	$.ajax({
		url: 'index.php?route=user/api/addip&token=<?php echo $token; ?>&api_id=<?php echo $api_id; ?>',
		type: 'post',
		data: 'ip=<?php echo $api_ip; ?>',
		dataType: 'json',
		beforeSend: function() {
			$('#button-ip-add').button('loading');
		},
		complete: function() {
			$('#button-ip-add').button('reset');
		},
		success: function(json) {
			$('.alert').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Currency
$('select[name=\'currency\']').on('change', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/currency&token=' + token,
		type: 'post',
		data: 'currency=' + $('select[name=\'currency\'] option:selected').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('select[name=\'currency\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('.fa-spin').remove();
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('select[name=\'currency\']').parent().parent().addClass('has-error');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Add all products to the cart using the api
$('#button-refresh').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/cart/products&token=' + token,
		dataType: 'json',
		crossDomain: true,
		success: function(json) {
			$('.alert-danger, .text-danger').remove();

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['stock']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['stock'] + '</div>');
				}

				if (json['error']['minimum']) {
					for (i in json['error']['minimum']) {
						$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['minimum'][i] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
					}
				}
			}

			var shipping = false;

			html = '';

			if (json['products'].length) {
				for (i = 0; i < json['products'].length; i++) {
					product = json['products'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + product['name'] + ' ' + (!product['stock'] ? '<span class="text-danger">***</span>' : '') + '<br />';
					html += '  <input type="hidden" name="product[' + i + '][product_id]" value="' + product['product_id'] + '" />';

					if (product['option']) {
						for (j = 0; j < product['option'].length; j++) {
							option = product['option'][j];

							html += '  - <small>' + option['name'] + ': ' + option['value'] + '</small><br />';

							if (option['type'] == 'select' || option['type'] == 'radio' || option['type'] == 'image') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['product_option_value_id'] + '" />';
							}

							if (option['type'] == 'checkbox') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + '][]" value="' + option['product_option_value_id'] + '" />';
							}

							if (option['type'] == 'text' || option['type'] == 'textarea' || option['type'] == 'file' || option['type'] == 'date' || option['type'] == 'datetime' || option['type'] == 'time') {
								html += '<input type="hidden" name="product[' + i + '][option][' + option['product_option_id'] + ']" value="' + option['value'] + '" />';
							}
						}
					}

					html += '</td>';
					html += '  <td class="text-left">' + product['model'] + '</td>';
					html += '  <td class="text-right"><div class="input-group btn-block" style="max-width: 200px;"><input type="text" name="product[' + i + '][quantity]" value="' + product['quantity'] + '" class="form-control" /><span class="input-group-btn"><button type="button" data-toggle="tooltip" title="<?php echo $button_refresh; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><i class="fa fa-refresh"></i></button></span></div></td>';
                    html += '  <td class="text-right">' + product['price'] + '</td>';
					html += '  <td class="text-right">' + product['total'] + '</td>';
					html += '  <td class="text-center" style="width: 3px;"><button type="button" value="' + product['cart_id'] + '" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
					html += '</tr>';

					if (product['shipping'] != 0) {
						shipping = true;
					}
				}
			}

			if (!shipping) {
				$('select[name=\'shipping_method\'] option').removeAttr('selected');
				$('select[name=\'shipping_method\']').prop('disabled', true);
				$('#button-shipping-method').prop('disabled', true);
			} else {
				$('select[name=\'shipping_method\']').prop('disabled', false);
				$('#button-shipping-method').prop('disabled', false);
			}

			if (json['vouchers'].length) {
				for (i in json['vouchers']) {
					voucher = json['vouchers'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + voucher['description'];
                    html += '    <input type="hidden" name="voucher[' + i + '][code]" value="' + voucher['code'] + '" />';
					html += '    <input type="hidden" name="voucher[' + i + '][description]" value="' + voucher['description'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][from_name]" value="' + voucher['from_name'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][from_email]" value="' + voucher['from_email'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][to_name]" value="' + voucher['to_name'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][to_email]" value="' + voucher['to_email'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][voucher_theme_id]" value="' + voucher['voucher_theme_id'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][message]" value="' + voucher['message'] + '" />';
                    html += '    <input type="hidden" name="voucher[' + i + '][amount]" value="' + voucher['amount'] + '" />';
					html += '  </td>';
					html += '  <td class="text-left"></td>';
					html += '  <td class="text-right">1</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '  <td class="text-center" style="width: 3px;"><button type="button" value="' + voucher['code'] + '" data-toggle="tooltip" title="<?php echo $button_remove; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
					html += '</tr>';
				}
			}

			if (!json['products'].length && !json['vouchers'].length) {
				html += '<tr>';
				html += '  <td colspan="6" class="text-center"><?php echo $text_no_results; ?></td>';
				html += '</tr>';
			}

			$('#cart').html(html);

			// Totals
			html = '';

			if (json['products'].length) {
				for (i = 0; i < json['products'].length; i++) {
					product = json['products'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + product['name'] + ' ' + (!product['stock'] ? '<span class="text-danger">***</span>' : '') + '<br />';

					if (product['option']) {
						for (j = 0; j < product['option'].length; j++) {
							option = product['option'][j];

							html += '  - <small>' + option['name'] + ': ' + option['value'] + '</small><br />';
						}
					}

					html += '  </td>';
					html += '  <td class="text-left">' + product['model'] + '</td>';
					html += '  <td class="text-right">' + product['quantity'] + '</td>';
					html += '  <td class="text-right">' + product['price'] + '</td>';
					html += '  <td class="text-right">' + product['total'] + '</td>';
					html += '</tr>';
				}
			}

			if (json['vouchers'].length) {
				for (i in json['vouchers']) {
					voucher = json['vouchers'][i];

					html += '<tr>';
					html += '  <td class="text-left">' + voucher['description'] + '</td>';
					html += '  <td class="text-left"></td>';
					html += '  <td class="text-right">1</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '  <td class="text-right">' + voucher['amount'] + '</td>';
					html += '</tr>';
				}
			}

			if (json['totals'].length) {
				for (i in json['totals']) {
					total = json['totals'][i];

					html += '<tr>';
					html += '  <td class="text-right" colspan="4">' + total['title'] + ':</td>';
					html += '  <td class="text-right">' + total['text'] + '</td>';
					html += '</tr>';
				}
			}

			if (!json['totals'].length && !json['products'].length && !json['vouchers'].length) {
				html += '<tr>';
				html += '  <td colspan="5" class="text-center"><?php echo $text_no_results; ?></td>';
				html += '</tr>';
			}

			$('#total').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Customer
$('input[name=\'customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=customer/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					customer_id: '0',
					customer_group_id: '<?php echo $customer_group_id; ?>',
					name: '<?php echo $text_none; ?>',
					customer_group: '',
					firstname: '',
					lastname: '',
					email: '',
					telephone: '',
					fax: '',
					custom_field: [],
					address: []
				});

				response($.map(json, function(item) {
					return {
						category: item['customer_group'],
						label: item['name'],
						value: item['customer_id'],
						customer_group_id: item['customer_group_id'],
						firstname: item['firstname'],
						lastname: item['lastname'],
						email: item['email'],
						telephone: item['telephone'],
						fax: item['fax'],
						custom_field: item['custom_field'],
						address: item['address']
					}
				}));
			}
		});
	},
	'select': function(item) {
		// Reset all custom fields
		$('#tab-customer input[type=\'text\'], #tab-customer textarea').not('#tab-customer input[name=\'customer\'], #tab-customer input[name=\'customer_id\']').val('');
		$('#tab-customer select option').removeAttr('selected');
		$('#tab-customer input[type=\'checkbox\'], #tab-customer input[type=\'radio\']').removeAttr('checked');

		$('#tab-customer input[name=\'customer\']').val(item['label']);
		$('#tab-customer input[name=\'customer_id\']').val(item['value']);
		$('#tab-customer select[name=\'customer_group_id\']').val(item['customer_group_id']);
		$('#tab-customer input[name=\'firstname\']').val(item['firstname']);
		$('#tab-customer input[name=\'lastname\']').val(item['lastname']);
		$('#tab-customer input[name=\'email\']').val(item['email']);
		$('#tab-customer input[name=\'telephone\']').val(item['telephone']);
		$('#tab-customer input[name=\'fax\']').val(item['fax']);

		for (i in item.custom_field) {
			$('#tab-customer select[name=\'custom_field[' + i + ']\']').val(item.custom_field[i]);
			$('#tab-customer textarea[name=\'custom_field[' + i + ']\']').val(item.custom_field[i]);
			$('#tab-customer input[name^=\'custom_field[' + i + ']\'][type=\'text\']').val(item.custom_field[i]);
			$('#tab-customer input[name^=\'custom_field[' + i + ']\'][type=\'hidden\']').val(item.custom_field[i]);
			$('#tab-customer input[name^=\'custom_field[' + i + ']\'][type=\'radio\'][value=\'' + item.custom_field[i] + '\']').prop('checked', true);

			if (item.custom_field[i] instanceof Array) {
				for (j = 0; j < item.custom_field[i].length; j++) {
					$('#tab-customer input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + item.custom_field[i][j] + '\']').prop('checked', true);
				}
			}
		}

		$('select[name=\'customer_group_id\']').trigger('change');

		html = '<option value="0"><?php echo $text_none; ?></option>';

		for (i in  item['address']) {
			html += '<option value="' + item['address'][i]['address_id'] + '">' + item['address'][i]['firstname'] + ' ' + item['address'][i]['lastname'] + ', ' + item['address'][i]['address_1'] + ', ' + item['address'][i]['city'] + ', ' + item['address'][i]['country'] + '</option>';
		}

		$('select[name=\'payment_address\']').html(html);
		$('select[name=\'shipping_address\']').html(html);

		$('select[name=\'payment_address\']').trigger('change');
		$('select[name=\'shipping_address\']').trigger('change');
	}
});

// Custom Fields
$('select[name=\'customer_group_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=customer/customer/customfield&token=<?php echo $token; ?>&customer_group_id=' + this.value,
		dataType: 'json',
		success: function(json) {
			$('.custom-field').hide();
			$('.custom-field').removeClass('required');

			for (i = 0; i < json.length; i++) {
				custom_field = json[i];

				$('.custom-field' + custom_field['custom_field_id']).show();

				if (custom_field['required']) {
					$('.custom-field' + custom_field['custom_field_id']).addClass('required');
				}
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'customer_group_id\']').trigger('change');

$('#button-customer').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/customer&token=' + token,
		type: 'post',
		data: $('#tab-customer input[type=\'text\'], #tab-customer input[type=\'hidden\'], #tab-customer input[type=\'radio\']:checked, #tab-customer input[type=\'checkbox\']:checked, #tab-customer select, #tab-customer textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-customer').button('loading');
		},
		complete: function() {
			 $('#button-customer').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-' + i.replace('_', '-'));

					if (element.parent().hasClass('input-group')) {
                   		$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
                // Refresh products, vouchers and totals
                var request_1 = $.ajax({
                    url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/cart/add&token=' + token,
                    type: 'post',
                    data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
                    dataType: 'json',
                    crossDomain: true,
                    beforeSend: function() {
                        $('#button-product-add').button('loading');
                    },
                    complete: function() {
                        $('#button-product-add').button('reset');
                    },
                    success: function(json) {
                        $('.alert, .text-danger').remove();
                        $('.form-group').removeClass('has-error');

                        if (json['error'] && json['error']['warning']) {
                            $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                        }
            		},
                    error: function(xhr, ajaxOptions, thrownError) {
                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                    }
                });

                var request_2 = request_1.then(function() {
                    $.ajax({
                        url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/voucher/add&token=' + token,
                        type: 'post',
                        data: $('#cart input[name^=\'voucher\'][type=\'text\'], #cart input[name^=\'voucher\'][type=\'hidden\'], #cart input[name^=\'voucher\'][type=\'radio\']:checked, #cart input[name^=\'voucher\'][type=\'checkbox\']:checked, #cart select[name^=\'voucher\'], #cart textarea[name^=\'voucher\']'),
                        dataType: 'json',
                        crossDomain: true,
                        beforeSend: function() {
                            $('#button-voucher-add').button('loading');
                        },
                        complete: function() {
                            $('#button-voucher-add').button('reset');
                        },
                        success: function(json) {
                            $('.alert, .text-danger').remove();
                            $('.form-group').removeClass('has-error');

                            if (json['error'] && json['error']['warning']) {
                                $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                            }
                		},
                        error: function(xhr, ajaxOptions, thrownError) {
                            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                        }
                    });
                });

                request_2.done(function() {
                    $('#button-refresh').trigger('click');

                    $('a[href=\'#tab-cart\']').tab('show');
                });
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#tab-product input[name=\'product\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id'],
						model: item['model'],
						option: item['option'],
						price: item['price']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('#tab-product input[name=\'product\']').val(item['label']);
		$('#tab-product input[name=\'product_id\']').val(item['value']);

		if (item['option'] != '') {
 			html  = '<fieldset>';
            html += '  <legend><?php echo $entry_option; ?></legend>';

			for (i = 0; i < item['option'].length; i++) {
				option = item['option'][i];

				if (option['type'] == 'select') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""><?php echo $text_select; ?></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'radio') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""><?php echo $text_select; ?></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'checkbox') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <div id="input-option' + option['product_option_id'] + '">';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<div class="checkbox">';

						html += '  <label><input type="checkbox" name="option[' + option['product_option_id'] + '][]" value="' + option_value['product_option_value_id'] + '" /> ' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '  </label>';
						html += '</div>';
					}

					html += '    </div>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'image') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <select name="option[' + option['product_option_id'] + ']" id="input-option' + option['product_option_id'] + '" class="form-control">';
					html += '      <option value=""><?php echo $text_select; ?></option>';

					for (j = 0; j < option['product_option_value'].length; j++) {
						option_value = option['product_option_value'][j];

						html += '<option value="' + option_value['product_option_value_id'] + '">' + option_value['name'];

						if (option_value['price']) {
							html += ' (' + option_value['price_prefix'] + option_value['price'] + ')';
						}

						html += '</option>';
					}

					html += '    </select>';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'text') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" class="form-control" /></div>';
					html += '</div>';
				}

				if (option['type'] == 'textarea') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10"><textarea name="option[' + option['product_option_id'] + ']" rows="5" id="input-option' + option['product_option_id'] + '" class="form-control">' + option['value'] + '</textarea></div>';
					html += '</div>';
				}

				if (option['type'] == 'file') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label">' + option['name'] + '</label>';
					html += '  <div class="col-sm-10">';
					html += '    <button type="button" id="button-upload' + option['product_option_id'] + '" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>';
					html += '    <input type="hidden" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" id="input-option' + option['product_option_id'] + '" />';
					html += '  </div>';
					html += '</div>';
				}

				if (option['type'] == 'date') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group date"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}

				if (option['type'] == 'datetime') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group datetime"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="YYYY-MM-DD HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}

				if (option['type'] == 'time') {
					html += '<div class="form-group' + (option['required'] ? ' required' : '') + '">';
					html += '  <label class="col-sm-2 control-label" for="input-option' + option['product_option_id'] + '">' + option['name'] + '</label>';
					html += '  <div class="col-sm-3"><div class="input-group time"><input type="text" name="option[' + option['product_option_id'] + ']" value="' + option['value'] + '" placeholder="' + option['name'] + '" data-date-format="HH:mm" id="input-option' + option['product_option_id'] + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';
					html += '</div>';
				}
			}

			html += '</fieldset>';

			$('#option').html(html);

			$('.date').datetimepicker({
				pickTime: false
			});

			$('.datetime').datetimepicker({
				pickDate: true,
				pickTime: true
			});

			$('.time').datetimepicker({
				pickDate: false
			});
		} else {
			$('#option').html('');
		}
	}
});

$('#button-product-add').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/cart/add&token=' + token,
		type: 'post',
		data: $('#tab-product input[name=\'product_id\'], #tab-product input[name=\'quantity\'], #tab-product input[name^=\'option\'][type=\'text\'], #tab-product input[name^=\'option\'][type=\'hidden\'], #tab-product input[name^=\'option\'][type=\'radio\']:checked, #tab-product input[name^=\'option\'][type=\'checkbox\']:checked, #tab-product select[name^=\'option\'], #tab-product textarea[name^=\'option\']'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-product-add').button('loading');
		},
		complete: function() {
			$('#button-product-add').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				if (json['error']['option']) {
					for (i in json['error']['option']) {
						var element = $('#input-option' + i.replace('_', '-'));

						if (element.parent().hasClass('input-group')) {
							$(element).parent().after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						} else {
							$(element).after('<div class="text-danger">' + json['error']['option'][i] + '</div>');
						}
					}
				}

				if (json['error']['store']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['store'] + '</div>');
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Voucher
$('#button-voucher-add').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/voucher/add&token=' + token,
		type: 'post',
		data: $('#tab-voucher input[type=\'text\'], #tab-voucher input[type=\'hidden\'], #tab-voucher input[type=\'radio\']:checked, #tab-voucher input[type=\'checkbox\']:checked, #tab-voucher select, #tab-voucher textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-voucher-add').button('loading');
		},
		complete: function() {
			$('#button-voucher-add').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-' + i.replace('_', '-'));

					if (element.parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				$('input[name=\'from_name\']').attr('value', '');
				$('input[name=\'from_email\']').attr('value', '');
				$('input[name=\'to_name\']').attr('value', '');
				$('input[name=\'to_email\']').attr('value', '');
				$('textarea[name=\'message\']').attr('value', '');
				$('input[name=\'amount\']').attr('value', '<?php echo addslashes($voucher_min); ?>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#cart').delegate('.btn-danger', 'click', function() {
	var node = this;

	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/cart/remove&token=' + token,
		type: 'post',
		data: 'key=' + encodeURIComponent(this.value),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$(node).button('loading');
		},
		complete: function() {
			$(node).button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			// Check for errors
			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			} else {
				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#cart').delegate('.btn-primary', 'click', function() {
    var node = this;

    // Refresh products, vouchers and totals
    $.ajax({
        url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/cart/add&token=' + token,
        type: 'post',
        data: $('#cart input[name^=\'product\'][type=\'text\'], #cart input[name^=\'product\'][type=\'hidden\'], #cart input[name^=\'product\'][type=\'radio\']:checked, #cart input[name^=\'product\'][type=\'checkbox\']:checked, #cart select[name^=\'product\'], #cart textarea[name^=\'product\']'),
        dataType: 'json',
        crossDomain: true,
        beforeSend: function() {
            $(node).button('loading');
        },
        complete: function() {
            $(node).button('reset');
        },
        success: function(json) {
            $('.alert, .text-danger').remove();
            $('.form-group').removeClass('has-error');

            if (json['error'] && json['error']['warning']) {
                $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
            }

            if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }).done(function() {
        $('#button-refresh').trigger('click');
    });
});

$('#button-cart').on('click', function() {
	$('a[href=\'#tab-payment\']').tab('show');
});

// Payment Address
$('select[name=\'payment_address\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=customer/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'payment_address\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#tab-payment .fa-spin').remove();
		},
		success: function(json) {
			// Reset all fields
			$('#tab-payment input[type=\'text\'], #tab-payment input[type=\'text\'], #tab-payment textarea').val('');
			$('#tab-payment select option').not('#tab-payment select[name=\'payment_address\']').removeAttr('selected');
			$('#tab-payment input[type=\'checkbox\'], #tab-payment input[type=\'radio\']').removeAttr('checked');

			$('#tab-payment input[name=\'firstname\']').val(json['firstname']);
			$('#tab-payment input[name=\'lastname\']').val(json['lastname']);
			$('#tab-payment input[name=\'company\']').val(json['company']);
			$('#tab-payment input[name=\'address_1\']').val(json['address_1']);
			$('#tab-payment input[name=\'address_2\']').val(json['address_2']);
			$('#tab-payment input[name=\'city\']').val(json['city']);
			$('#tab-payment input[name=\'postcode\']').val(json['postcode']);
			$('#tab-payment select[name=\'country_id\']').val(json['country_id']);

			payment_zone_id = json['zone_id'];

			for (i in json['custom_field']) {
				$('#tab-payment select[name=\'custom_field[' + i + ']\']').val(json['custom_field'][i]);
				$('#tab-payment textarea[name=\'custom_field[' + i + ']\']').val(json['custom_field'][i]);
				$('#tab-payment input[name^=\'custom_field[' + i + ']\'][type=\'text\']').val(json['custom_field'][i]);
				$('#tab-payment input[name^=\'custom_field[' + i + ']\'][type=\'hidden\']').val(json['custom_field'][i]);
				$('#tab-payment input[name^=\'custom_field[' + i + ']\'][type=\'radio\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);
				$('#tab-payment input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);

				if (json['custom_field'][i] instanceof Array) {
					for (j = 0; j < json['custom_field'][i].length; j++) {
						$('#tab-payment input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i][j] + '\']').prop('checked', true);
					}
				}
			}

			$('#tab-payment select[name=\'country_id\']').trigger('change');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var payment_zone_id = '<?php echo $payment_zone_id; ?>';

$('#tab-payment select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-payment select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#tab-payment .fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#tab-payment input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#tab-payment input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == payment_zone_id) {
	      				html += ' selected="selected"';
	    			}

	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#tab-payment select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#tab-payment select[name=\'country_id\']').trigger('change');

$('#button-payment-address').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/payment/address&token=' + token,
		type: 'post',
		data: $('#tab-payment input[type=\'text\'], #tab-payment input[type=\'hidden\'], #tab-payment input[type=\'radio\']:checked, #tab-payment input[type=\'checkbox\']:checked, #tab-payment select, #tab-payment textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-payment-address').button('loading');
		},
		complete: function() {
			$('#button-payment-address').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-payment-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				// Payment Methods
				$.ajax({
					url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/payment/methods&token=' + token,
					dataType: 'json',
					crossDomain: true,
					beforeSend: function() {
						$('#button-payment-address i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
						$('#button-payment-address').prop('disabled', true);
					},
					complete: function() {
						$('#button-payment-address i').replaceWith('<i class="fa fa-arrow-right"></i>');
						$('#button-payment-address').prop('disabled', false);
					},
					success: function(json) {
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} else {
							html = '<option value=""><?php echo $text_select; ?></option>';

							if (json['payment_methods']) {
								for (i in json['payment_methods']) {
									if (json['payment_methods'][i]['code'] == $('select[name=\'payment_method\'] option:selected').val()) {
										html += '<option value="' + json['payment_methods'][i]['code'] + '" selected="selected">' + json['payment_methods'][i]['title'] + '</option>';
									} else {
										html += '<option value="' + json['payment_methods'][i]['code'] + '">' + json['payment_methods'][i]['title'] + '</option>';
									}
								}
							}

							$('select[name=\'payment_method\']').html(html);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				}).done(function() {
                    // Refresh products, vouchers and totals
    				$('#button-refresh').trigger('click');

    				// If shipping required got to shipping tab else total tabs
    				if ($('select[name=\'shipping_method\']').prop('disabled')) {
    					$('a[href=\'#tab-total\']').tab('show');
    				} else {
    					$('a[href=\'#tab-shipping\']').tab('show');
    				}
                });
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Shipping Address
$('select[name=\'shipping_address\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=customer/customer/address&token=<?php echo $token; ?>&address_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'shipping_address\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#tab-shipping .fa-spin').remove();
		},
		success: function(json) {
			// Reset all fields
			$('#tab-shipping input[type=\'text\'], #tab-shipping input[type=\'text\'], #tab-shipping textarea').val('');
			$('#tab-shipping select option').not('#tab-shipping select[name=\'shipping_address\']').removeAttr('selected');
			$('#tab-shipping input[type=\'checkbox\'], #tab-shipping input[type=\'radio\']').removeAttr('checked');

			$('#tab-shipping input[name=\'firstname\']').val(json['firstname']);
			$('#tab-shipping input[name=\'lastname\']').val(json['lastname']);
			$('#tab-shipping input[name=\'company\']').val(json['company']);
			$('#tab-shipping input[name=\'address_1\']').val(json['address_1']);
			$('#tab-shipping input[name=\'address_2\']').val(json['address_2']);
			$('#tab-shipping input[name=\'city\']').val(json['city']);
			$('#tab-shipping input[name=\'postcode\']').val(json['postcode']);
			$('#tab-shipping select[name=\'country_id\']').val(json['country_id']);

			shipping_zone_id = json['zone_id'];

			for (i in json['custom_field']) {
				$('#tab-shipping select[name=\'custom_field[' + i + ']\']').val(json['custom_field'][i]);
				$('#tab-shipping textarea[name=\'custom_field[' + i + ']\']').val(json['custom_field'][i]);
				$('#tab-shipping input[name^=\'custom_field[' + i + ']\'][type=\'text\']').val(json['custom_field'][i]);
				$('#tab-shipping input[name^=\'custom_field[' + i + ']\'][type=\'hidden\']').val(json['custom_field'][i]);
				$('#tab-shipping input[name^=\'custom_field[' + i + ']\'][type=\'radio\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);
				$('#tab-shipping input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i] + '\']').prop('checked', true);

				if (json['custom_field'][i] instanceof Array) {
					for (j = 0; j < json['custom_field'][i].length; j++) {
						$('#tab-shipping input[name^=\'custom_field[' + i + ']\'][type=\'checkbox\'][value=\'' + json['custom_field'][i][j] + '\']').prop('checked', true);
					}
				}
			}

			$('#tab-shipping select[name=\'country_id\']').trigger('change');
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

var shipping_zone_id = '<?php echo $shipping_zone_id; ?>';

$('#tab-shipping select[name=\'country_id\']').on('change', function() {
	$.ajax({
		url: 'index.php?route=localisation/country/country&token=<?php echo $token; ?>&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('#tab-shipping select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
		},
		complete: function() {
			$('#tab-shipping .fa-spin').remove();
		},
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#tab-shipping input[name=\'postcode\']').parent().parent().addClass('required');
			} else {
				$('#tab-shipping input[name=\'postcode\']').parent().parent().removeClass('required');
			}

			html = '<option value=""><?php echo $text_select; ?></option>';

			if (json['zone'] && json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';

					if (json['zone'][i]['zone_id'] == shipping_zone_id) {
	      				html += ' selected="selected"';
	    			}

	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}

			$('#tab-shipping select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#tab-shipping select[name=\'country_id\']').trigger('change');

$('#button-shipping-address').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/shipping/address&token=' + token,
		type: 'post',
		data: $('#tab-shipping input[type=\'text\'], #tab-shipping input[type=\'hidden\'], #tab-shipping input[type=\'radio\']:checked, #tab-shipping input[type=\'checkbox\']:checked, #tab-shipping select, #tab-shipping textarea'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-shipping-address').button('loading');
		},
		complete: function() {
			$('#button-shipping-address').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			// Check for errors
			if (json['error']) {
				if (json['error']['warning']) {
					$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error']['warning'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				}

				for (i in json['error']) {
					var element = $('#input-shipping-' + i.replace('_', '-'));

					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}

				// Highlight any found errors
				$('.text-danger').parentsUntil('.form-group').parent().addClass('has-error');
			} else {
				// Shipping Methods
				var request = $.ajax({
					url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/shipping/methods&token=' + token,
					dataType: 'json',
					beforeSend: function() {
						$('#button-shipping-address i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
						$('#button-shipping-address').prop('disabled', true);
					},
					complete: function() {
						$('#button-shipping-address i').replaceWith('<i class="fa fa-arrow-right"></i>');
						$('#button-shipping-address').prop('disabled', false);
					},
					success: function(json) {
						if (json['error']) {
							$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
						} else {
							// Shipping Methods
							html = '<option value=""><?php echo $text_select; ?></option>';

							if (json['shipping_methods']) {
								for (i in json['shipping_methods']) {
									html += '<optgroup label="' + json['shipping_methods'][i]['title'] + '">';

									if (!json['shipping_methods'][i]['error']) {
										for (j in json['shipping_methods'][i]['quote']) {
											if (json['shipping_methods'][i]['quote'][j]['code'] == $('select[name=\'shipping_method\'] option:selected').val()) {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '" selected="selected">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											} else {
												html += '<option value="' + json['shipping_methods'][i]['quote'][j]['code'] + '">' + json['shipping_methods'][i]['quote'][j]['title'] + ' - ' + json['shipping_methods'][i]['quote'][j]['text'] + '</option>';
											}
										}
									} else {
										html += '<option value="" style="color: #F00;" disabled="disabled">' + json['shipping_method'][i]['error'] + '</option>';
									}

									html += '</optgroup>';
								}
							}

							$('select[name=\'shipping_method\']').html(html);
						}
					},
					error: function(xhr, ajaxOptions, thrownError) {
						alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
					}
				}).done(function() {
				    // Refresh products, vouchers and totals
				    $('#button-refresh').trigger('click');

                    $('a[href=\'#tab-total\']').tab('show');
                });
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Shipping Method
$('#button-shipping-method').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/shipping/method&token=' + token,
		type: 'post',
		data: 'shipping_method=' + $('select[name=\'shipping_method\'] option:selected').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-shipping-method').button('loading');
		},
		complete: function() {
			$('#button-shipping-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('select[name=\'shipping_method\']').parent().parent().parent().addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Payment Method
$('#button-payment-method').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/payment/method&token=' + token,
		type: 'post',
		data: 'payment_method=' + $('select[name=\'payment_method\'] option:selected').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-payment-method').button('loading');
		},
		complete: function() {
			$('#button-payment-method').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('select[name=\'payment_method\']').parent().parent().parent().addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Coupon
$('#button-coupon').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/coupon&token=' + token,
		type: 'post',
		data: 'coupon=' + $('input[name=\'coupon\']').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-coupon').button('loading');
		},
		complete: function() {
			$('#button-coupon').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('input[name=\'coupon\']').parent().parent().parent().addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Voucher
$('#button-voucher').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/voucher&token=' + token,
		type: 'post',
		data: 'voucher=' + $('input[name=\'voucher\']').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-voucher').button('loading');
		},
		complete: function() {
			$('#button-voucher').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('input[name=\'voucher\']').parent().parent().parent().addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Reward
$('#button-reward').on('click', function() {
	$.ajax({
		url: $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/reward&token=' + token,
		type: 'post',
		data: 'reward=' + $('input[name=\'reward\']').val(),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-reward').button('loading');
		},
		complete: function() {
			$('#button-reward').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();
			$('.form-group').removeClass('has-error');

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Highlight any found errors
				$('input[name=\'reward\']').parent().parent().parent().addClass('has-error');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

				// Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

// Affiliate
$('input[name=\'affiliate\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=marketing/affiliate/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					affiliate_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['affiliate_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'affiliate\']').val(item['label']);
		$('input[name=\'affiliate_id\']').val(item['value']);
	}
});

// Checkout
$('#button-save').on('click', function() {
	if ($('input[name=\'order_id\']').val() == 0) {
		var url = $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/order/add&token=' + token;
	} else {
		var url = $('select[name=\'store\'] option:selected').val() + 'index.php?route=api/order/edit&token=' + token + '&order_id=' + $('input[name=\'order_id\']').val();
	}

	$.ajax({
		url: url,
		type: 'post',
		data: $('select[name=\'payment_method\'] option:selected,  select[name=\'shipping_method\'] option:selected,  #tab-total select[name=\'order_status_id\'], #tab-total select, #tab-total textarea[name=\'comment\'], #tab-total input[name=\'affiliate_id\']'),
		dataType: 'json',
		crossDomain: true,
		beforeSend: function() {
			$('#button-save').button('loading');
		},
		complete: function() {
			$('#button-save').button('reset');
		},
		success: function(json) {
			$('.alert, .text-danger').remove();

			if (json['error']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			}

			if (json['success']) {
				$('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

                // Refresh products, vouchers and totals
				$('#button-refresh').trigger('click');
            }

			if (json['order_id']) {
				$('input[name=\'order_id\']').val(json['order_id']);
			}
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('#content').delegate('button[id^=\'button-upload\'], button[id^=\'button-custom-field\'], button[id^=\'button-payment-custom-field\'], button[id^=\'button-shipping-custom-field\']', 'click', function() {
	var node = this;

	$('#form-upload').remove();

	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');

	$('#form-upload input[name=\'file\']').trigger('click');

	if (typeof timer != 'undefined') {
    	clearInterval(timer);
	}

	timer = setInterval(function() {
		if ($('#form-upload input[name=\'file\']').val() != '') {
			clearInterval(timer);

			$.ajax({
				url: 'index.php?route=tool/upload/upload&token=<?php echo $token; ?>',
				type: 'post',
				dataType: 'json',
				data: new FormData($('#form-upload')[0]),
				cache: false,
				contentType: false,
				processData: false,
				beforeSend: function() {
					$(node).button('loading');
				},
				complete: function() {
					$(node).button('reset');
				},
				success: function(json) {
					$(node).parent().find('.text-danger').remove();

					if (json['error']) {
						$(node).parent().find('input[type=\'hidden\']').after('<div class="text-danger">' + json['error'] + '</div>');
					}

					if (json['success']) {
						alert(json['success']);
					}

					if (json['code']) {
						$(node).parent().find('input[type=\'hidden\']').attr('value', json['code']);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}
			});
		}
	}, 500);
});

$('.date').datetimepicker({
	pickTime: false
});

$('.datetime').datetimepicker({
	pickDate: true,
	pickTime: true
});

$('.time').datetimepicker({
	pickDate: false
});
//--></script>
  <script type="text/javascript">
// Sort the custom fields
$('#tab-customer .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-customer .form-group').length) {
		$('#tab-customer .form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#tab-customer .form-group').length) {
		$('#tab-customer .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#tab-customer .form-group').length) {
		$('#tab-customer .form-group:first').before(this);
	}
});

// Sort the custom fields
$('#tab-payment .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-payment .form-group').length) {
		$('#tab-payment .form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#tab-payment .form-group').length) {
		$('#tab-payment .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#tab-payment .form-group').length) {
		$('#tab-payment .form-group:first').before(this);
	}
});

$('#tab-shipping .form-group[data-sort]').detach().each(function() {
	if ($(this).attr('data-sort') >= 0 && $(this).attr('data-sort') <= $('#tab-shipping .form-group').length) {
		$('#tab-shipping .form-group').eq($(this).attr('data-sort')).before(this);
	}

	if ($(this).attr('data-sort') > $('#tab-shipping .form-group').length) {
		$('#tab-shipping .form-group:last').after(this);
	}

	if ($(this).attr('data-sort') < -$('#tab-shipping .form-group').length) {
		$('#tab-shipping .form-group:first').before(this);
	}
});

$('#button-total').click(function() {

  var total = $('#input-total').val();

  if (isNaN(total)) {
    alert('总价必须为数字！');
    return false;
  }

  if (confirm('确定修改价格为' + total)==false) {
    return false;
  }

  $.ajax({
    url: 'index.php?route=sale/order/updateTotal&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>',
    type: 'post',
    data: 'total=' + total,
    dataType: 'json',
    crossDomain: true,
    success: function(json) {
      $('.alert, .text-danger').remove();

      if (json['error']) {
        $('#content > .container-fluid').prepend('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['success']) {
        $('#content > .container-fluid').prepend('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '  <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

        // Refresh products, vouchers and totals
        $('#button-refresh').trigger('click');
      }

      if (json['order_id']) {
        $('input[name=\'order_id\']').val(json['order_id']);
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});

//订单历史的相关修改，拷贝自order_info.tpl
$('#history').delegate('.pagination a', 'click', function(e) {
  e.preventDefault();

  $('#history').load(this.href);
});

$('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

$('#button-history').on('click', function() {
  $.ajax({
    url: '<?php echo $store_url; ?>index.php?route=api/order/history&token=' + token + '&order_id=<?php echo $order_id; ?>',
    type: 'post',
    dataType: 'json',
    data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&notify=' + ($('input[name=\'notify\']').prop('checked') ? 1 : 0) + '&override=' + ($('input[name=\'override\']').prop('checked') ? 1 : 0) + '&append=' + ($('input[name=\'append\']').prop('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
    beforeSend: function() {
      $('#button-history').button('loading');
    },
    complete: function() {
      $('#button-history').button('reset');
    },
    success: function(json) {
      $('.alert').remove();

      if (json['error']) {
        $('#history').before('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');
      }

      if (json['success']) {
        $('#history').load('index.php?route=sale/order/history&token=<?php echo $token; ?>&order_id=<?php echo $order_id; ?>');

        $('#history').before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + ' <button type="button" class="close" data-dismiss="alert">&times;</button></div>');

        $('textarea[name=\'comment\']').val('');
      }
    },
    error: function(xhr, ajaxOptions, thrownError) {
      alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    }
  });
});
</script></div>
<?php echo $footer; ?>
