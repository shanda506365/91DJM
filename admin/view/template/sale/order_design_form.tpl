<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-information" data-toggle="tooltip" title="保存" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="返回" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> 订单设计方案</h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-information" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab">信息</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword">标题：</label>
                <div class="col-sm-10">
                  <input type="text" name="title" value="<?php echo $title; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_title) { ?>
                  <div class="text-danger"><?php echo $error_title; ?></div>
                  <?php } ?>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-description">描述：</label>
                <div class="col-sm-10">
                  <textarea name="description" id="input-description" style="width: 100%;height:80px;"><?php echo isset($description) ? $description : ''; ?></textarea>
                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-description">添加日期：</label>
                <div class="col-sm-10 form-control-static">
                  <?php echo $date_added; ?>
                </div>
              </div>

            </div>
          </div>


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

        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>